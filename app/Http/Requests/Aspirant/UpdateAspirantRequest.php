<?php

namespace App\Http\Requests;

use App\Enums\AspirantOffice;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class UpdateAspirantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $aspirantId = $this->route('aspirant')?->id;

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($aspirantId)],
            'password' => ['nullable', 'string', 'min:8'],
            'phone' => ['nullable', 'string', 'max:20'],
            'gender' => ['nullable', 'string'],
            'education_status' => ['nullable', 'string'],
            'office' => ['required', new Enum(AspirantOffice::class)],
            'constituency_id' => ['required', 'uuid', 'exists:constituencies,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'vision' => ['nullable', 'string'],
            'mission' => ['nullable', 'string'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'overall_progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'total_supporters' => ['nullable', 'integer', 'min:0'],
            'supporters_growth_this_week' => ['nullable', 'integer'],
            'campaign_team_members' => ['nullable', 'integer', 'min:0'],
        ];
    }
}