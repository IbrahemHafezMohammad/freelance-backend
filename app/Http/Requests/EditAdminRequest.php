<?php

namespace App\Http\Requests;

use App\Rules\PhoneRegex;
use App\Rules\UserNameRegex;
use Illuminate\Validation\Rule;
use App\Constants\UserConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class EditAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('edit-admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', Rule::unique(UserConstants::TABLE_NAME, 'phone')->ignore($this->admin->user->id), new PhoneRegex],
        ];
    }

    public function getUserData()
    {
        $validated = $this->validated();
        return [
            'phone' => $validated['phone'],
            'name' => $validated['name']
        ];
    }
}
