<?php

namespace App\Http\Requests\API\Pet;

use App\Models\Owner;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // basic info
            'name' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'species' => ['required', 'exists:species,id'],
            'breed' => ['required', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'is_microchipped' => ['required', 'integer'],
            'owner_id' => ['exists:owners,id'],
            // details
            'details' => 'array',
            'details.age' => ['required', 'string'],
            'details.birthdate' => ['required', 'string'],
            'details.coat' => ['nullable', 'string'],
            'details.pattern' => ['nullable', 'string'],
            'details.weight' => ['nullable', 'string'],
            'details.last_weighed_at' => ['nullable', 'string'],
            'details.is_disabled' => ['nullable', 'integer'],
            // vaccination
            'vaccines' => 'array',
            'vaccines.*.clinic_id' => ['required', 'exists:clinics,id'],
            'vaccines.*.vaccine' => ['nullable', 'string'],
            'vaccines.*.last_vaccinated_at' => ['nullable', 'string'],
            // deworming
            'dewormers' => 'array',
            'dewormers.*.clinic_id' => ['required', 'exists:clinics,id'],
            'dewormers.*.dewormer' => ['nullable', 'string'],
            'dewormers.*.last_dewormed_at' => ['nullable', 'string'],
        ];
    }

    public function getId(): int
    {
        return (int) $this->route('id');
    }

    public function getOwnerId(): int
    {
        $loggedInUserID = auth()->user()->id;
        $owner = Owner::where('user_id', $loggedInUserID)->first();
        return (int) $owner->id;
    }

    public function getName(): string
    {
        return $this->input('name');
    }

    public function getGender(): string
    {
        return $this->input('gender');
    }

    public function getSpecies(): string
    {
        return $this->input('species');
    }
    
    public function getBreed(): string
    {
        return $this->input('breed');
    }

    public function getPhoto(): mixed
    {
        return $this->file('photo', null);
    }

    public function getIsMicrochipped(): int
    {
        return $this->input('is_microchipped');
    }

    public function getAge(): string
    {
        return $this->input('details.age');
    }
    
    public function getBirthdate(): string
    {
        return $this->input('details.birthdate');
    }

    public function getCoat(): string
    {
        return $this->input('details.coat');
    }

    public function getPattern(): string
    {
        return $this->input('details.pattern');
    }

    public function getWeight(): string
    {
        return $this->input('details.weight');
    }

    public function getLastWeighedAt(): string
    {
        return $this->input('details.last_weighed_at');
    }

    public function getIsDisabled(): int
    {
        return $this->input('details.is_disabled');
    }
}
