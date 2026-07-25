<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_super_admin'
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
        'password' => 'hashed',
    ];

     /**
     * Check if the user has an 'admin' role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has a 'donor' role.
     *
     * @return bool
     */
    public function isDonor(): bool
    {
        return $this->role === 'donor';
    }

    /**
     * Check if the user has a 'patient' role.
     *
     * @return bool
     */
    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    /**
     * Check if the user has a 'super admin' role.
     *
     * @return bool
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    /**
     * Get the donor associated with the user.
     */
    public function donor(): HasOne
    {
        return $this->hasOne(Donor::class);
    }

     /**
     * Get the patient associated with the user.
     */
    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class);
    }

    /**
     * The camps that the user is staffed in.
     */
    public function camps(): BelongsToMany
    {
        return $this->belongsToMany(Camp::class, 'camp_staff')
                    ->withPivot('role_in_camp')
                    ->withTimestamps();
    }

    /**
     * Get the blood requests made by the user.
     */
    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class, 'requester_user_id');
    }

    /**
     * Get the blood issues created by the user.
     */
    public function bloodIssues(): HasMany
    {
        return $this->hasMany(BloodIssue::class, 'issued_by_user_id');
    }

    /**
     * Get the reserved units made by the user.
     */
    public function reservedUnits(): HasMany
    {
        return $this->hasMany(ReservedUnit::class, 'reserved_by_user_id');
    }

    /**
     * Get the transfusion reactions reported by the user.
     */
    public function transfusionReactions(): HasMany
    {
        return $this->hasMany(TransfusionReaction::class, 'reported_by_user_id');
    }

    /**
     * Get the news articles authored by the user.
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class, 'author_user_id');
    }

    /**
     * Get the serology tests performed by the user.
     */
    public function serologyTests(): HasMany
    {
        return $this->hasMany(SerologyTest::class, 'tested_by_user_id');
    }
}
