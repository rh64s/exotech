<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CatalogShowRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'body_zones' => ['sometimes', 'array'],
            'body_zones.*' => ['integer', 'exists:body_zones,id'],
            'types' => ['sometimes', 'array'],
            'types.*' => ['integer', 'exists:module_types,id'],
            'categories' => ['sometimes', 'array'],
            'categories.*' => ['integer', 'exists:module_categories,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', 'gte:min_price'],
        ];
    }
}
