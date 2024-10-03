<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Pet\UpdatePetRequest;
use Exception;
use Illuminate\Http\Request;
use App\Services\API\PetService;
use App\Http\Resources\PetResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Pet\CreatePetRequest;
use App\Http\Requests\API\Pet\SearchPetRequest;

class PetController extends Controller
{
    /** @var PetService */
    protected $petService;

    /**
     * PetController constructor.
     *
     * @param PetService $petService
     */
    public function __construct(PetService $petService)
    {
        parent::__construct();

        $this->petService = $petService;
    }

    /**
     * Supplier List
     * No search bar yet as of implementing this module
     * @return void
     */
    public function index(SearchPetRequest $request)
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

            $results = $this->petService->search($conditions);
            $this->response = array_merge($results, $this->response);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    // Create a new pet profile
    public function store(CreatePetRequest $request)
    {
        $request->validated();
        
        try {
            $formData = [
                'name' => $request->getName(),
                'gender' => $request->getGender(),
                'species' => $request->getSpecies(),
                'breed' => $request->getBreed(),
                'photo' => $request->getPhoto(),
                'is_microchipped' => $request->getIsMicrochipped(),
                'owner_id' => $request->getOwnerId(),
            ];

            $pet = $this->petService->create($formData);
            $this->response['data'] = new PetResource($pet);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'message' => $e->getMessage(),
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    // Retrieve a pet profile
    public function read($id)
    {
        try {
            $pet = $this->petService->findById((int) $id);
            $this->response['data'] = new PetResource($pet);
        } catch (Exception $e) {
            $this->response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        }

        return response()->json($this->response, $this->response['code']);
    }

    // Update an existing pet profile
    public function update(UpdatePetRequest $request)
    {
        $request->validated();
        
        try {
            $formData = [
                'id' => $request->getId(),
                'name' => $request->getName(),
                'gender' => $request->getGender(),
                'species' => $request->getSpecies(),
                'breed' => $request->getBreed(),
                'photo' => $request->getPhoto(),
                'is_microchipped' => $request->getIsMicrochipped(),
                'owner_id' => $request->getOwnerId(),
            ];

            if ($request->has('details')) {
                $formData['details'] = [
                    'age' => $request->getAge(),
                    'birthdate' => $request->getBirthdate(),
                    'coat' => $request->getCoat(),
                    'pattern' => $request->getPattern(),
                    'weight' => $request->getWeight(),
                    'last_weighed_at' => $request->getLastWeighedAt(),
                    'is_disabled' => $request->getIsDisabled(),
                ];
            }

            if ($request->has('vaccines')) {
                $formData['vaccines'] = $request->get('vaccines');
            }

            if ($request->has('dewormers')) {
                $formData['dewormers'] = $request->get('dewormers');
            }
            // dd($formData);

            $pet = $this->petService->update($formData);
            $this->response['data'] = new PetResource($pet);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet not found'], 404);
        }
    }

    // Soft delete a pet profile
    public function delete($id)
    {
        try {
            $pet = auth()->user()->pets()->findOrFail($id);
            $pet->delete();

            return response()->json(['message' => 'Pet profile deleted successfully']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet not found'], 404);
        }
    }

    // Force delete a pet profile
    public function deleteForce($id)
    {
        try {
            $pet = auth()->user()->pets()->withTrashed()->findOrFail($id); // Include soft-deleted records
            $pet->forceDelete();

            return response()->json(['message' => 'Pet profile permanently deleted']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Pet not found'], 404);
        }
    }
}
