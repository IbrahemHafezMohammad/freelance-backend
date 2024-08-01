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
            'employer_id' => auth()->user()->employer->id,
            'is_active' => true,
            'status' => JobPostConstants::STATUS_OPENED,
        ];
    }
}
