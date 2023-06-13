<?php

namespace App\Http\Requests\Auth;

use App\Helpers\ResponseFormatter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
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
