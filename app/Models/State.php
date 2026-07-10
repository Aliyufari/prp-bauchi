<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class State extends Model
{
    use HasUuids;

    protected $fillable = ['name'];

    public function zones(): HasMany
    {
        return $this->hasMany(Zone::class);
    }

    public function users(): MorphMany
    {
        return $this->morphMany(User::class, 'location');
    }
}
