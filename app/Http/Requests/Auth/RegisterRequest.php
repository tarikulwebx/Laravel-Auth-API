<?php

namespace App\Http\Requests\Auth;

use App\Http\Helpers\Helper;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"     => "required|string|max:255",
            "email"    => "required|string|email|max:255|unique:users",
            "password" => "required|string|min:6|confirmed",
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        return Helper::errorResponse("Validation error!", $validator->errors(), 422);
    }
}
