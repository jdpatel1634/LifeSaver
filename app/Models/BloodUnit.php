<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BloodUnit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unique_bag_id',
        'donor_id',
        'blood_group_id',
        'collection_date',
        'expiry_date',
        'component_type',
        'volume_ml',
        'collection_camp_id',
        'status',
        'serology_test_status',
        'storage_location',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'collection_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the donor that owns the blood unit.
     */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    /**
     * Get the blood group that owns the blood unit.
     */
    public function bloodGroup(): BelongsTo
    {
        return $this->belongsTo(BloodGroup::class);
    }

    /**
     * Get the camp that collected the blood unit.
     */
    public function collectionCamp(): BelongsTo
    {
        return $this->belongsTo(Camp::class, 'collection_camp_id');
    }

    /**
     * Get the serology tests for the blood unit.
     */
    public function serologyTests(): HasMany
    {
        return $this->hasMany(SerologyTest::class);
    }

    /**
     * Get the blood issue associated with the blood unit.
     */
    public function bloodIssue(): HasOne
    {
        return $this->hasOne(BloodIssue::class);
    }

    /**
     * Get the reserved unit associated with the blood unit.
     */
    public function reservedUnit(): HasOne
    {
        return $this->hasOne(ReservedUnit::class);
    }

    /**
     * Get the transfusion reactions for the blood unit.
     */
    public function transfusionReactions(): HasMany
    {
        return $this->hasMany(TransfusionReaction::class);
    }
}
