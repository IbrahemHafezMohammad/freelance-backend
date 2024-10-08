<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ViewEmployerDashboard extends FormRequest
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
            'desc' => ['nullable', 'string'],
            'title' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'status' => ['nullable', 'integer'],
            'created_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
