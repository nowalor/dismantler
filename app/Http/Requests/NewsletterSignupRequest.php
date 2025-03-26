<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;
use App\Traits\ValidatesRecaptcha;


class NewsletterSignupRequest extends FormRequest
{
    use ValidatesRecaptcha;
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'string|nullable',
            'email' => 'required|email|unique:newsletter_signees',
            'recaptcha_token' => 'required|string',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->addRecaptchaValidation($validator);
        });
    }
}
