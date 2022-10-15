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
        ];
    }
}
