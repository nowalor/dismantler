<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilterBrowsingCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'country' => 'required|string|in:da,de,fr,pl,sv', // only allowed countries
        ];
    }

    public function messages()
    {
        return [
            'country.in' => 'Currently not shipping to the selected country.'
        ];
    }
}
