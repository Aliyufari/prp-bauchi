<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Constituency extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'type',
        'state_id',
        'zone_id',
        'lga_id',
        'ward_id',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    public function aspirants(): HasMany
    {
        return $this->hasMany(Aspirant::class);
    }
}