<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservedUnit extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'blood_unit_id',
        'patient_id',
        'blood_request_id',
        'reserved_by_user_id',
        'reservation_date',
        'expiration_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'reservation_date' => 'datetime',
        'expiration_date' => 'datetime',
    ];

    /**
     * Get the blood unit that owns the reserved unit.
     */
    public function bloodUnit(): BelongsTo
    {
        return $this->belongsTo(BloodUnit::class);
    }

    /**
     * Get the blood request .
     */
    public function bloodRequest(): BelongsTo
    {
        return $this->belongsTo(BloodRequest::class);
    }

    /**
     * Get the patient that owns the reserved unit.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the user that reserved the blood unit.
     */
    public function reservedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reserved_by_user_id');
    }
}
