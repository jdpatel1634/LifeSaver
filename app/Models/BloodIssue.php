<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BloodIssue extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'blood_request_id',
        'patient_id',
        'blood_unit_id',
        'issue_date',
        'issued_by_user_id',
        'cross_match_status',
        'payment_status',
        'total_amount',
        'adjustment_details',
        'receipt_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'issue_date' => 'datetime',
    ];

    /**
     * Get the blood request that owns the blood issue.
     */
    public function bloodRequest(): BelongsTo
    {
        return $this->belongsTo(BloodRequest::class);
    }

    /**
     * Get the patient that owns the blood issue.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the blood unit that owns the blood issue.
     */
    public function bloodUnit(): BelongsTo
    {
        return $this->belongsTo(BloodUnit::class);
    }

    /**
     * Get the user that issued the blood unit.
     */
    public function issuedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by_user_id');
    }
}
