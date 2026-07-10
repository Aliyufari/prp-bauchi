<?php

namespace App\Http\Requests\ReturningOfficer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReturningOfficerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $officerId = $this->route('returning_officer')?->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($officerId)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'education_status' => ['nullable', 'string'],
            'application_id' => ['nullable', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'posting_location' => ['required', 'string', 'max:255'],
            'state_id' => ['nullable', 'uuid', 'exists:states,id'],
            'zone_id' => ['nullable', 'uuid', 'exists:zones,id'],
            'lga_id' => ['nullable', 'uuid', 'exists:lgas,id'],
            'ward_id' => ['nullable', 'uuid', 'exists:wards,id'],
            'pu_id' => ['nullable', 'uuid', 'exists:pus,id'],
        ];
    }
}