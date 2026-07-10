<?php

namespace App\Models;

use App\Enums\CoordinatorType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coordinator extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'type' => CoordinatorType::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
