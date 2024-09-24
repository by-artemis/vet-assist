<?php

namespace App\Services\API;

use App\Http\Resources\PetResource;
use App\Models\User;
use DB;
use Exception;
use App\Models\Pet;

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
        $userIsAdmin = User::find($loggedInUserID)->hasRole('System Admin');

        // initialize query
        $query = $userIsAdmin ? 
            $this->pet :
            $this->pet->where('owner_id', auth()->user()->id);

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
}
