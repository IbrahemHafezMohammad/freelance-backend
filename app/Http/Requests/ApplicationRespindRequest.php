<?php

namespace App\Http\Requests;

use App\Constants\JobApplicationConstants;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRespindRequest extends FormRequest
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
            'job_application_id' => [
                'required',
                'integer',
                Rule::exists(JobApplicationConstants::TABLE_NAME, 'id')
                    ->where('status', JobApplicationConstants::STATUS_PENDING)
            ],
            'is_accepted' => ['required', 'boolean'],
        ];
    }
}
