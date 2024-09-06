<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'is_licensed',
        'specialty',
        'email_address',
        'phone_number',
    ];

    /**
     * Gets the doctor that belongs to the vet clinic
     *
     * @return BelongsTo
     */
    public function clinic(): BelongsTo
    {
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }

    /**
     * Gets the appointments of the doctor
     *
     * @return HasMany
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(DoctorAppointment::class);
    }
}