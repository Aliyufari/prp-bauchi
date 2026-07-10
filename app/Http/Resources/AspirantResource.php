<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AspirantResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->profile?->phone,
            'status' => $this->is_active ? 'active' : 'inactive',

            'office' => $this->aspirant?->office?->value,
            'office_label' => $this->aspirant?->office
                ? ucwords(str_replace('_', ' ', strtolower($this->aspirant->office->value)))
                : null,
            'title' => $this->aspirant?->title,
            'vision' => $this->aspirant?->vision,
            'mission' => $this->aspirant?->mission,
            'image_url' => $this->aspirant?->picture ?? $this->aspirant?->avatar,

            'overall_progress' => $this->aspirant?->overall_progress ?? 0,
            'total_supporters' => $this->aspirant?->total_supporters ?? 0,
            'supporters_growth_this_week' => $this->aspirant?->supporters_growth_this_week ?? 0,
            'campaign_team_members' => $this->aspirant?->campaign_team_members ?? 0,

            'constituency_id' => $this->aspirant?->constituency_id,
            'constituency' => $this->aspirant?->constituency?->name,

            'state' => $this->profile?->state?->name,

            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}