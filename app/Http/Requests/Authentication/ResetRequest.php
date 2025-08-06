<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class ResetRequest extends FormRequest
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
            "password" => "required|string|same:password_confirm|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[!@#$%¨&*]/",
            "password_confirm" => "required|string|same:password"
        ];
    }

    public function messages()
    {
        return [
            "password.required" => "É necessário inserir uma senha.",
            "password.string" => "É necessário inserir uma senha em texto.",
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.regex' => 'A senha deve conter letras maiúsculas, minúsculas, números e caracteres especiais.',
            "password.same" => "As duas senhas precisam ser iguais.",
            "password_confirm.required" => "É necessário inserir uma senha.",
            "password_confirm.string" => "É necessário inserir uma senha em texto.",
            "password_confirm.same" => "As duas senhas precisam ser iguais.",
        ];
    }
}
