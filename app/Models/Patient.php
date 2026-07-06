<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'mobile_number',
        'email',
        'gender',
        'date_of_birth',
        'address',
        'hospital_name',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
    ];

    /**
     * Get the user that owns the patient.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the blood requests for the patient.
     */
    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class);
    }

    /**
     * Get the blood issues for the patient.
     */
    public function bloodIssues(): HasMany
    {
        return $this->hasMany(BloodIssue::class);
    }

    /**
     * Get the reserved units for the patient.
     */
    public function reservedUnits(): HasMany
    {
        return $this->hasMany(ReservedUnit::class);
    }

    /**
     * Get the transfusion reactions for the patient.
     */
    public function transfusionReactions(): HasMany
    {
        return $this->hasMany(TransfusionReaction::class);
    }
}
