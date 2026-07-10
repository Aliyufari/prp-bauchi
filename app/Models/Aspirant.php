<?php

namespace App\Models;

use App\Enums\AspirantOffice;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Aspirant extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'constituency_id',
        'office',
        'title',
        'vision',
        'mission',
        'avatar',
        'picture',
        'overall_progress',
        'total_supporters',
        'supporters_growth_this_week',
        'campaign_team_members',
    ];

    protected function casts(): array
    {
        return [
            'office' => AspirantOffice::class,
            'overall_progress' => 'integer',
            'total_supporters' => 'integer',
            'supporters_growth_this_week' => 'integer',
            'campaign_team_members' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function constituency(): BelongsTo
    {
        return $this->belongsTo(Constituency::class);
    }
}