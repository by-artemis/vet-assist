<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Gets the clinics that offer the service
     *
     * @return BelongsToMany
     */
    public function clinics()
    {
        return $this->belongsToMany(Clinic::class, 'clinic_services', 'service_id', 'clinic_id');
    }
}