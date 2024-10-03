<?php

namespace App\Services\API;

use App\Models\PetDewormer;
use DB;
use Exception;
use App\Models\Pet;
use App\Models\User;
use App\Models\Owner;
use App\Http\Resources\PetResource;
use App\Exceptions\PetNotFoundException;

class PetService
{
    /** @var \App\Models\Pet */
    protected $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function search(array $conditions): array
    {
        // default to 1 if page not provided
        $page = 1;
        $limit = config('search.results_per_page');

        if (array_key_exists('page', $conditions) === true) {
            $page = $conditions['page'];
        }

        if (array_key_exists('limit', $conditions) === true) {
            $limit = $conditions['limit'];
        }

        $skip = ($page > 1) ? ($page * $limit - $limit) : 0;

        $loggedInUserID = auth()->user()->id;
        $owner = Owner::where('user_id', $loggedInUserID)->first();
        $userIsAdmin = User::find($loggedInUserID)->hasRole('System Admin');

        // initialize query
        $query = $userIsAdmin ? 
            $this->pet :
            $this->pet->where('owner_id', $owner->id);

        // if keyword is provided
        if (array_key_exists('keyword', $conditions)) {
            $query = $query->where(function ($query) use ($conditions) {
                $query->where('name', 'LIKE', "%{$conditions['keyword']}%")
                    ->orWhere('gender', 'LIKE', "%{$conditions['keyword']}%")
                    ->orWhere('species', 'LIKE', "%{$conditions['keyword']}%")
                    ->orWhere('breed', 'LIKE', "%{$conditions['keyword']}%");
            });
        }

        // perform user search
        $results = $query->skip($skip)
            ->whereNull('deleted_at')
            ->orderBy($conditions['sort'], $conditions['order'])
            ->paginate($limit);

        $urlParams = ['keyword' => $conditions['keyword'], 'limit' => $limit];

        return paginated($results, PetResource::class, $page, $urlParams);
    }

    public function create(array $data): Pet
    {
        DB::beginTransaction();

        try {
            $pet = $this->pet->create($data);
            
            DB::commit();

            return $pet;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data): Pet
    {
        DB::beginTransaction();

        try {
            $pet = $this->findById($data['id']);
            // dd($pet->dewormers());
            // dd($data);

            $pet->update($data);

            // Update related models (if applicable)
            if ($data['details']) {
                $pet->details()
                    ->where('pet_id', $data['id'])
                    ->updateOrCreate([], $data['details']);
            }

            if ($data['vaccines']) {
                $pet->vaccines()->delete();
                $pet->vaccines()->upsert(
                    $data['vaccines'],
                    ['pet_id', 'vaccine', 'last_vaccinated_at'],
                    ['vaccine', 'last_vaccinated_at']
                );
            }

            if ($data['dewormers']) {
                $pet->dewormers()->delete();
                $pet->dewormers()->upsert(
                    $data['dewormers'],
                    ['pet_id', 'dewormer', 'last_dewormed_at'],
                    ['dewormer', 'last_dewormed_at']
                );
            }

            DB::commit();

            return $pet;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findById(int $id): Pet
    {
        $pet = $this->pet
            ->with('details', 'vaccines', 'dewormers')
            ->find($id);

        if (!($pet instanceof Pet)) {
            throw new PetNotFoundException();
        }

        return $pet;
    }
}
