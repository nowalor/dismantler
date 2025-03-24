<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;

class NewsletterSignupRequest extends FormRequest
{
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
            $recaptcha = new GoogleReCaptcha(config('recaptcha.api_secret_key'));

            $response = $recaptcha
                ->setExpectedAction('newsletter')
                ->verify($this->recaptcha_token, $this->ip());

            if (!$response->isSuccess()) {
                $validator->errors()->add('recaptcha_token', __('reCAPTCHA verification failed. Please try again.'));
            }
        });
    }
}
