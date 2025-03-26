<?php

namespace App\Traits;

use Illuminate\Contracts\Validation\Validator;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;

trait ValidatesRecaptcha
{

    public function addRecaptchaValidation(Validator $validator)
    {
        $secretKey = config('recaptcha.api_secret_key');
        $recaptcha = new GoogleReCaptcha($secretKey);

        $response = $recaptcha
            ->setExpectedAction($this->expectedRecaptchaAction)
            ->verify($this->input('recaptcha_token'), $this->ip());

        if (!$response->isSuccess()) {
            $validator->errors()->add('recaptcha_token', __('reCAPTCHA verification failed. Please try again.'));
        }
    }
}
