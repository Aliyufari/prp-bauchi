<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturningOfficerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'avatar_url' => null,

            'status' => $this->is_active ? 'active' : 'inactive',

            'officer_no' => $this->profile?->application_id,
            'phone' => $this->profile?->phone,
            'gender' => $this->profile?->gender,
            'occupation' => $this->profile?->occupation,
            'education_status' => $this->profile?->education_status,

            'institution' => $this->returningOfficer?->institution,
            'posting_location' => $this->returningOfficer?->posting_location,

            'state_id' => $this->profile?->state_id,
            'zone_id' => $this->profile?->zone_id,
            'lga_id' => $this->profile?->lga_id,
            'ward_id' => $this->profile?->ward_id,
            'pu_id' => $this->profile?->pu_id,

            'state' => $this->profile?->state?->name,
            'zone' => $this->profile?->zone?->name,
            'lga' => $this->profile?->lga?->name,
            'ward' => $this->profile?->ward?->name,
            'pu' => $this->profile?->pu?->name,

            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}