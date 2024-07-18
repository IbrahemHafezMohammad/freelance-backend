<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use App\Constants\CategoryConstants;
use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->can('create-category');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', Rule::unique(CategoryConstants::TABLE_NAME, 'name')],
            'image' => ['required', 'string'],
        ];
    }

    public function getCategoryData()
    {
        $validated = $this->validated();

        return [
            'name' => $validated['name'],
            'image' => $validated['image'],
            'status' => true,
        ];
    }
}
