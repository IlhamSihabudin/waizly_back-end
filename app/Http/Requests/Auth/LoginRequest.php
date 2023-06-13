<?php

namespace App\Http\Requests\Auth;

use App\Helpers\ResponseFormatter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return mixed
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $message = $validator->messages()->first();
        $response = ResponseFormatter::error(null, $message);
        throw new ValidationException($validator, $response);
    }
}
