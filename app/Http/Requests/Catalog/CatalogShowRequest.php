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
            'types' => ['sometimes', 'array'],
            'types.*' => ['integer', 'exists:module_types,id'],
            'characteristic_values' => ['sometimes', 'array', 'list', 'max:50'],
            'characteristic_values.*' => ['required', 'integer', 'min:1', 'distinct'],
            'search' => ['nullable', 'string', 'max:100'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0', ...($this->filled('min_price') ? ['gte:min_price'] : [])],
            ...($this->routeIs('catalog.frames') ? [
                'max_weight_g' => ['nullable', 'integer', 'min:0'],
                'min_total_weight_g' => ['nullable', 'integer', 'min:0'],
            ] : [
                'saved' => ['sometimes', 'boolean'],
                'interface' => ['sometimes', 'integer', 'exists:attachment_interfaces,id'],
                'body_zones' => ['sometimes', 'array'],
                'body_zones.*' => ['integer', 'exists:body_zones,id'],
            ]),
        ];
    }
}
