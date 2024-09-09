<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'birthdate',
        'gender',
        'species',
        'breed',
        'is_microchipped',
    ];

    /**
     * Gets the pet that belongs to the owner (user)
     *
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Gets the details of the pet
     *
     * @return HasOne
     */
    public function details(): HasOne
    {
        return $this->hasOne(PetDetail::class);
    }

    /**
     * Gets the vaccines of the pet
     *
     * @return HasMany
     */
    public function vaccines(): HasMany
    {
        return $this->hasMany(PetVaccine::class);
    }

    /**
     * Gets the doctor's appointment of the pet
     *
     * @return HasOne
     */
    public function doctorAppointment(): HasOne
    {
        return $this->hasOne(DoctorAppointment::class);
    }
}