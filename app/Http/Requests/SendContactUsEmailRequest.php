<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;

class SendContactUsEmailRequest extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:50',
            'message' => 'required|string',
            'phone' => 'string',
            'plate' => 'string',
            'vin' => 'string',
            'recaptcha_token' => 'required|string',
        ];
    }
    // recaptcha v3
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $recaptchaToken = $this->recaptcha_token;
            $recaptchaSecret = config('recaptcha.api_secret_key');

            $recaptcha = new GoogleReCaptcha($recaptchaSecret);
            $response = $recaptcha
                ->setExpectedAction('contact') // MUST match the JS action
                ->verify($recaptchaToken, $this->ip());

            if (!$response->isSuccess()) {
                $validator->errors()->add('recaptcha_token', __('reCAPTCHA verification failed. Please try again.'));
            }
        });
    }
}
