<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'occupation',
        'education_status',
        'training_status',
        'mentor_name',
        'mentor_status',
        'applied_id',
        'state_id',
        'zone_id',
        'lga_id',
        'ward_id',
        'pu_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function pu(): BelongsTo
    {
        return $this->belongsTo(Pu::class);
    }
}