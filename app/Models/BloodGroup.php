<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'group_name',
        'description',
    ];

    /**
     * Get the donors for the blood group.
     */
    public function donors(): HasMany
    {
        return $this->hasMany(Donor::class);
    }

    /**
     * Get the blood units for the blood group.
     */
    public function bloodUnits(): HasMany
    {
        return $this->hasMany(BloodUnit::class);
    }

    /**
     * Get the blood requests for the blood group.
     */
    public function bloodRequests(): HasMany
    {
        return $this->hasMany(BloodRequest::class);
    }
}
