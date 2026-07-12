<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'blood_group_id',
        'units_requested',
        'urgency_level',
        'rejection_reason',
        'request_date',
        'required_by_date',
        'status',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'request_date' => 'date',
        'required_by_date' => 'date',
    ];

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (! $model->request_date) {
                $model->request_date = now();
            }
    
            if (auth()->check() && ! $model->patient_id) {
                $model->patient_id = auth()->user()->patient->id;
            }
    
            if (! $model->status) {
                $model->status = 'pending';
            }
        });
    }

    /**
     * Get the patient that made the blood request.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }


    /**
     * Get the blood group for the blood request.
     */
    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    /**
     * Get the blood issues for the blood request.
     */
    public function bloodIssues(): HasMany
    {
        return $this->hasMany(BloodIssue::class);
    }

    /**
     * Get the available blood units for the blood request.
     */
    public function bloodUnits(): HasMany
    {
        // This is a dummy relationship to satisfy Filament's RelationManager
        // The actual query logic is in AvailableBloodUnitsRelationManager.
        return $this->hasMany(BloodUnit::class, 'blood_group_id', 'blood_group_id');
    }

    /**
     * Get the reserved unit for the blood request.
     */
    public function reservedUnit(): HasOne
    {
        return $this->hasOne(ReservedUnit::class);
    }

    /**
     * Get the blood issue for the blood request.
     */
    public function bloodIssue(): HasOne
    {
        return $this->hasOne(BloodIssue::class);
    }
}
