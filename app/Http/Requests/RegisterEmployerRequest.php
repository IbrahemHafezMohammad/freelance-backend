<?php

namespace App\Http\Requests;

use App\Rules\PhoneRegex;
use App\Rules\PasswordRegex;
use App\Rules\UserNameRegex;
use Illuminate\Validation\Rule;
use App\Constants\UserConstants;
use App\Constants\GlobalConstants;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterEmployerRequest extends FormRequest
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
            'user_name' => ['required', 'string', Rule::unique(UserConstants::TABLE_NAME, 'user_name'), new UserNameRegex],
            'password' => ['required', 'string', new PasswordRegex],
            'email' => ['required', 'string', 'email', Rule::unique(UserConstants::TABLE_NAME, 'email')],
            'phone' => ['required', 'string', Rule::unique(UserConstants::TABLE_NAME, 'phone'), new PhoneRegex],
            'name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'integer', Rule::in(array_keys(UserConstants::getGenders()))],
            'language' => ['required', 'integer', Rule::in(array_keys(GlobalConstants::getLanguages()))],
            'birthday' => 'date_format:Y-m-d H:i:s',
        ];
    }

    public function getEmployerData($validated)
    {
        return [
            'allow_positing' => true,
        ];
    }

    public function getUserData($validated)
    {
        return [
            'user_name' => $validated['user_name'],
            'password' => $validated['password'],
            'phone' => $validated['phone'],
            'gender' => $validated['gender'] ?? UserConstants::GENDER_UNKNOWN,
            'name' => $validated['name'],
            'language' => $validated['language'],
            'birthday' => $validated['birthday'] ?? null,
            'email' => $validated['email'],
            'is_active' => true,
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => false,
            'message' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
