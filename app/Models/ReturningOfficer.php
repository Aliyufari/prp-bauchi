<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturningOfficer extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'institution',
        'posting_location',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
