<?php

namespace App\Models;

use App\Enums\SupervisoryAgentType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupervisoryAgent extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'type',
        'agents_supervised',
    ];

    protected function casts(): array
    {
        return [
            'type' => SupervisoryAgentType::class,
            'agents_supervised' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}