<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment_platform' => ['required', 'exists:payment_platforms,id'],
            'payment_method' => 'required',
            /* 'currency' => ['required', 'exists:currencies,iso'], */
            'name' => 'required|string',
            'email' => 'required|string',
            'address' => 'required|string',
            /* 'country' => 'required|string', */
            'town' => 'required|string',
            'zip_code' => 'required|string',

        ];
    }
}
