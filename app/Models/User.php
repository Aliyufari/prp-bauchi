<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasUuids, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'email_verified_at',
        'password',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function aspirant(): HasOne
    {
        return $this->hasOne(Aspirant::class);
    }

    public function coordinator(): HasOne
    {
        return $this->hasOne(Coordinator::class);
    }

    public function partyAgent(): HasOne
    {
        return $this->hasOne(PartyAgent::class);
    }

    public function returningOfficer(): HasOne
    {
        return $this->hasOne(ReturningOfficer::class);
    }

    public function stakeholder(): HasOne
    {
        return $this->hasOne(Stakeholder::class);
    }

    public function supervisoryAgent(): HasOne
    {
        return $this->hasOne(SupervisoryAgent::class);
    }
}
