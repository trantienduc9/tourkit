<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Allow all users
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'view_count' => 'required|integer|min:0|max:10000000000000000',
            'categories' => 'required|array|min:1', // At least one category should be selected
            'categories.*' => 'exists:categories,id', // Check if the category exists in the categories table
        ];
    }

    /**
     * Customize the error messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'The title is required.',
            'content.required' => 'The content is required.',
            'content.max' => 'The content cannot be longer than 10,000 characters.',
            'view_count.min' => 'The view count cannot be less than 0.',
            'view_count.max' => 'The view count cannot exceed the maximum limit.',
            'categories.required' => 'At least one category must be selected.',
            'categories.*.exists' => 'The selected category is invalid.',
        ];
    }
}
