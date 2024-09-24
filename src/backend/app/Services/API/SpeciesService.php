<?php

namespace App\Services\API;

use DB;
use Exception;
use App\Models\Species;
use App\Http\Resources\SpeciesResource;

class SpeciesService
{
    /** @var \App\Models\Species */
    protected $species;

    public function __construct(Species $species)
    {
        $this->species = $species;
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
        $query = $this->species;

        // if keyword is provided
        if (array_key_exists('keyword', $conditions)) {
            $query = $query->where('name', 'LIKE', "%{$conditions['keyword']}%");
        }

        // perform user search
        $results = $query->skip($skip)
            ->orderBy($conditions['sort'], $conditions['order'])
            ->paginate($limit);

        $urlParams = ['keyword' => $conditions['keyword'], 'limit' => $limit];

        return paginated($results, SpeciesResource::class, $page, $urlParams);
    }

    public function create(array $data): Species
    {
        DB::beginTransaction();

        try {
            $species = $this->species->create($data);

            DB::commit();

            return $species;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
