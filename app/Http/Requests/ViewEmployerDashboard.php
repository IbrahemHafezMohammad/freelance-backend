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
            'min_rate' => ['nullable', 'decimal'],
            'max_rate' => ['nullable', 'decimal'],
            'payment_type' => ['nullable', 'integer'],
            'bid_start_time' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'bid_end_time' => ['nullable', 'date_format:Y-m-d H:i:s'],
            'created_at' => ['nullable', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
