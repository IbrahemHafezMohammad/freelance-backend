<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Constants\SkillConstants;
use App\Constants\CategoryConstants;
use Illuminate\Foundation\Http\FormRequest;

class CreateSkillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create-skill');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(SkillConstants::TABLE_NAME, 'name')],
            'category_id' => ['required', 'integer', Rule::exists(CategoryConstants::TABLE_NAME,'id')],
        ];
    }

    // public function getSkillData(): array
    // {
    //     $validated = $this->validated();
    //     return [
    //         'name'=> $validated['name'],
    //         'category_id'=> $validated['category_id'],

    //     ];
    // }
}
