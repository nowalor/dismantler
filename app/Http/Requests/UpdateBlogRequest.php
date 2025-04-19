<?php

namespace App\Http\Requests;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'published_at' => 'sometimes|date',
            'tags' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'language' => [
                'required',
                'string',
                Rule::in(array_keys(LaravelLocalization::getSupportedLocales())),
            ],
        ];
    }
}
