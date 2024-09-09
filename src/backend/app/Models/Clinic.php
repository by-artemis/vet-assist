<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Clinic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'website',
        'description',
    ];

    /**
     * Gets the exact address of the vet clinic
     *
     * @return HasOne
     */
    public function address(): HasOne
    {
        return $this->hasOne(ClinicLocation::class);
    }

    /**
     * Gets the services of the vet clinic
     *
     * @return BelongsToMany
     */
    public function services()
    {
        return $this->belongsToMany(Service::class, 'vet_clinic_services', 'clinic_id', 'service_id');
    }

    /**
     * Gets the doctor's appointments of the vet clinic
     *
     * @return HasMany
     */
    public function doctorAppointments(): HasMany
    {
        return $this->hasMany(DoctorAppointment::class);
    }

    /**
     * Gets the doctors of the vet clinic
     *
     * @return HasMany
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }

    /**
     * Gets the reviews of the vet clinic
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Gets the user visit to the vet clinic
     *
     * @return HasOne
     */
    public function userClinicVisit(): HasOne
    {
        return $this->hasOne(UserClinicVisit::class);
    }

    /**
     * Gets the pet vaccines of the vet clinic
     *
     * @return HasMany
     */
    public function petVaccines(): HasMany
    {
        return $this->hasMany(ClinicLocation::class);
    }

    /**
     * Gets the users who favorited the vet clinic
     *
     * @return BelongsToMany
     */
    public function favoriteBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'clinic_id', 'user_id');
    }
}