<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'username',
        'password',
        'email_verified_at',
        'login_attempts',
        'user_status_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Specify the guard to be used in role & permission
     *
     * @var string
     */
    public $guard_name = 'api';

    /**
     * Gets the user's full name
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Gets all activation tokens of the user
     *
     * @return HasMany
     */
    public function activationTokens()
    {
        return $this->hasMany(ActivationToken::class);
    }

    /**
     * Gets the status that belong to the user
     *
     * @return BelongsTo
     */
    public function status()
    {
        return $this->belongsTo(UserStatus::class, 'user_status_id');
    }

    /**
     * Gets the role of the user
     *
     * @return HasOne
     */
    public function userRole(): HasOne
    {
        return $this->hasOne(UserRole::class);
    }

    /**
     * Gets the type of the user
     *
     * @return HasOne
     */
    public function userType(): HasOne
    {
        return $this->hasOne(UserType::class);
    }

    /**
     * Gets the details of the user
     *
     * @return HasOne
     */
    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * Gets the vet clinic favorites that belong to the user
     *
     * @return HasMany
     */
    public function favoriteClinics(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Gets the vet clinic reviews that belong to the user
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
     * Gets the owner details of the user
     *
     * @return HasOne
     */
    public function owner(): HasOne
    {
        return $this->hasOne(Owner::class);
    }
}
