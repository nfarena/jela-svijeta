<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'per_page' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'category' => 'nullable|integer',
            'meals.tags' => 'nullable|array',
            'meals.tags.*' => 'integer',
            'mealswith' => 'nullable|array',
            'meals.with.*' => 'string|in:ingredients,category,tags', 
            'lang' => 'required|string',
            'diff_time' => 'nullable|integer',
        ];
    }
}
