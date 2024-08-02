<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListJobsRequest extends FormRequest
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
            'title' => ['nullable', 'string'],
            'employer' => ['nullable', 'string'],
            'skills' => ['nullable', 'array'],
            'skills.*' => ['integer'],
            'create_at' => ['date_format:Y-m-d H:i:s'],
        ];
    }
}
