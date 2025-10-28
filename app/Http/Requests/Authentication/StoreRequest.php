<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            "password" => "required|string",
            "email" => [
                "required",
                "email",
                "regex:/^[a-zA-Z0-9._%+-]+@ufca\.edu\.br$/",
                "exists:users,email",
            ]
        ];
    }

    public function messages()
    {
        return [
            "password.required" => "A senha é obrigatória.",
            "password.string" => "A senha deve ser válida.",

            "email.required" => "O e-mail é obrigatório.",
            "email.email" => "Insira um e-mail válido.",
            "email.regex" => "O e-mail deve pertencer ao domínio @ufca.edu.br.",
            "email.exists" => "Este e-mail é inválido.",
        ];
    }
}
