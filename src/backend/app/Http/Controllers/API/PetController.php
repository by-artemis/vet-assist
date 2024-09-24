<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Pet\CreatePetRequest;
use App\Http\Requests\API\Pet\SearchPetRequest;
use App\Http\Resources\PetResource;
use Exception;
use Illuminate\Http\Request;
use App\Services\API\PetService;
use App\Http\Controllers\Controller;

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
        try {
            $pet = $this->petService->create($request->validated());
            $this->response['data'] = new PetResource($pet);
        } catch (Exception $e) { // @codeCoverageIgnoreStart
            $this->response = [
                'error' => $e->getMessage(),
                'message' => $e->getMessage(),
            ];
        } // @codeCoverageIgnoreEnd

        return response()->json($this->response, $this->response['code']);
    }

    // Update an existing pet profile
    public function update(Request $request, $id)
    {
        try {
            $pet = auth()->user()->pets()->findOrFail($id); // Find the pet belonging to the user

            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|string',
                'gender' => 'sometimes|in:male,female',
                // ... other fields with validation rules ...
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $pet->update($request->all()); // Update the pet

            // Update related pet details and vaccines if needed

            return response()->json(['message' => 'Pet profile updated successfully', 'pet' => $pet]);

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
