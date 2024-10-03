<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SpeciesResource;
use Exception;
use App\Http\Controllers\Controller;
use App\Services\API\SpeciesService;
use App\Http\Requests\API\Species\SearchSpeciesRequest;

class SpeciesController extends Controller
{
    /** @var SpeciesService */
    protected $speciesService;

    /**
     * PetController constructor.
     *
     * @param SpeciesService $speciesService
     */
    public function __construct(SpeciesService $speciesService)
    {
        parent::__construct();

        $this->speciesService = $speciesService;
    }
   
    public function index(SearchSpeciesRequest $request)
    {
        $request->validated();

        try {
            $conditions = [
                'keyword' => $request->getKeyword(),
                'page' => $request->getPage(),
                'limit' => $request->getLimit(),
                'order' => $request->getOrder(),
                'sort' => $request->getSort(),
            ];

            $results = $this->speciesService->search($conditions);
            $this->response = array_merge($results, $this->response);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    // Retrieve a species
    public function read($id)
    {
        try {
            $species = $this->speciesService->findById((int) $id);
            $this->response['data'] = new SpeciesResource($species);
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
