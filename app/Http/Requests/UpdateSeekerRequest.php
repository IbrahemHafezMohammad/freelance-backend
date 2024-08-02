<?php

namespace App\Http\Requests;

use App\Rules\PhoneRegex;
use Illuminate\Validation\Rule;
use App\Constants\UserConstants;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSeekerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', Rule::unique(UserConstants::TABLE_NAME, 'email')->ignore($this->user->id)],
            'phone' => ['required', 'string', Rule::unique(UserConstants::TABLE_NAME, 'phone')->ignore($this->user->id), new PhoneRegex],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'integer', Rule::in(array_keys(UserConstants::getGenders()))],
            'headline' => ['nullable', 'string', 'max:255'],
            'desc' => ['nullable', 'string', 'max:500'],
            'birthday' => ['nullable', 'date_format:Y-m-d'],
            'resume' => ['nullable', 'string'],
        ];
    }

    public function getUserData($validated)
    {
        return [
            'phone' => $validated['phone'],
            'gender' => $validated['gender'] ?? UserConstants::GENDER_UNKNOWN,
            'name' => $validated['name'],
            'birthday' => $validated['birthday'] ?? null,
        ];
    }

    public function getSeekerData($validated)
    {
        return [
            'headline' => $validated['headline'] ?? null,
            'desc' => $validated['desc'] ?? null,
        ];
    }
}
