<?php

namespace App\Services\API;

use DB;
use Exception;
use App\Models\Clinic;
use App\Http\Resources\ClinicResource;
use App\Exceptions\ClinicNotFoundException;

class ClinicService
{
    /** @var \App\Models\Clinic */
    protected $clinic;

    public function __construct(Clinic $clinic)
    {
        $this->clinic = $clinic;
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

        // initialize query
        $query = $this->clinic;

        // if keyword is provided
        if (array_key_exists('keyword', $conditions)) {
            $query = $query->where('name', 'LIKE', "%{$conditions['keyword']}%");
        }

        // perform user search
        $results = $query->skip($skip)
            ->orderBy($conditions['sort'], $conditions['order'])
            ->paginate($limit);

        $urlParams = ['keyword' => $conditions['keyword'], 'limit' => $limit];

        return paginated($results, ClinicResource::class, $page, $urlParams);
    }

    public function create(array $data): Clinic
    {
        DB::beginTransaction();

        try {
            $clinic = $this->clinic->create($data);

            DB::commit();

            return $clinic;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findById(int $id): Clinic
    {
        $clinic = $this->clinic->find($id);

        if (!($clinic instanceof Clinic)) {
            throw new ClinicNotFoundException();
        }

        return $clinic;
    }
}
