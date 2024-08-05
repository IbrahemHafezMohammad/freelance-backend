<?php

namespace App\Http\Requests;

use App\Constants\JobPostConstants;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SeekerApplicationRequest extends FormRequest
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
            'job_post_id' => [
                'required',
                'integer', Rule::exists(JobPostConstants::TABLE_NAME, 'id')
                    ->where('is_active', true)
                    ->where('status', JobPostConstants::STATUS_OPENED)
            ],
            'resume' => ['required', 'string'],
            'message' => ['nullable', 'string', 'max:500'],
        ];
    }
}
