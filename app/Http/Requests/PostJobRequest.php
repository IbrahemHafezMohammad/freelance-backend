<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Constants\SkillConstants;
use App\Constants\JobPostConstants;
use Illuminate\Foundation\Http\FormRequest;

class PostJobRequest extends FormRequest
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
            'desc' => ['required', 'string', 'min:50', 'max:3000'],
            'title' => ['required', 'string', 'min:1', 'max:255'],
            'image' => ['nullable', 'string', 'max:2048'],
            'min_rate' => ['required','decimal:0,5'],
            'max_rate' => ['required','decimal:0,5'],
            'payment_type' => ['required', 'integer', Rule::in(array_keys(JobPostConstants::getPaymentTypes()))],
            'bid_start_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'bid_end_time' => ['required', 'date_format:Y-m-d H:i:s'],
            'skills' => ['required', 'array'],
            'skills.*' => ['required','integer', Rule::exists(SkillConstants::TABLE_NAME, 'id')],
        ];
    }

    public function getPostData($validated): array
    {
        return [
            'desc' => $validated['desc'], 
            'title' => $validated['title'],
            'image' => $validated['image'] ?? null,
            'min_rate' => $validated['min_rate'],
            'max_rate' => $validated['max_rate'],
            'payment_type' => $validated['payment_type'],
            'bid_start_time' => $validated['bid_start_time'],
            'bid_end_time' => $validated['bid_end_time'],
            'employer_id' => auth()->user()->employer->id,
            'is_active' => true,
            'status' => JobPostConstants::STATUS_OPENED,
        ];
    }
}
