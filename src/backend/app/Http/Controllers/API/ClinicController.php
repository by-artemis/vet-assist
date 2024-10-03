<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Services\API\ClinicService;
use App\Http\Controllers\Controller;
use App\Http\Resources\ClinicResource;
use App\Http\Requests\API\Clinic\SearchClinicRequest;

class ClinicController extends Controller
{
    /** @var ClinicService */
    protected $clinicService;

    /**
     * PetController constructor.
     *
     * @param ClinicService $clinicService
     */
    public function __construct(ClinicService $clinicService)
    {
        parent::__construct();

        $this->clinicService = $clinicService;
    }

    public function index(SearchClinicRequest $request)
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

            $results = $this->clinicService->search($conditions);
            $this->response = array_merge($results, $this->response);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    // Retrieve a clinics
    public function read($id)
    {
        try {
            $species = $this->clinicService->findById((int) $id);
            $this->response['data'] = new ClinicResource($species);
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }
}
