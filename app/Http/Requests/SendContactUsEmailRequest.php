<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use ReCaptcha\ReCaptcha as GoogleReCaptcha;
use App\Traits\ValidatesRecaptcha;
class SendContactUsEmailRequest extends FormRequest
{
    use ValidatesRecaptcha;
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
            'plate' => 'sometimes|string|nullable',
            'vin' => 'sometimes|string',
            'recaptcha_token' => 'required|string',
        ];
    }
    // recaptcha v3
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $this->addRecaptchaValidation($validator);
        });
    }
}
