<?php

namespace App\Http\Requests\SupervisoryAgent;

use App\Enums\SupervisoryAgentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreSupervisoryAgentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'education_status' => ['nullable', 'string'],
            'application_id' => ['nullable', 'string', 'max:255'],
            'type' => ['required', new Enum(SupervisoryAgentType::class)],
            'agents_supervised' => ['nullable', 'integer', 'min:0'],
            'state_id' => ['nullable', 'uuid', 'exists:states,id'],
            'zone_id' => ['nullable', 'uuid', 'exists:zones,id'],
            'lga_id' => ['nullable', 'uuid', 'exists:lgas,id'],
            'ward_id' => ['nullable', 'uuid', 'exists:wards,id'],
            'pu_id' => ['nullable', 'uuid', 'exists:pus,id'],
        ];
    }
}