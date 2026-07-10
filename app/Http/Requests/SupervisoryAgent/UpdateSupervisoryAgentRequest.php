<?php

namespace App\Http\Requests\SupervisoryAgent;

use App\Enums\SupervisoryAgentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateSupervisoryAgentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $agentId = $this->route('supervisory_agent')?->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($agentId)],
            'password' => ['nullable', 'string', 'min:8'],
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