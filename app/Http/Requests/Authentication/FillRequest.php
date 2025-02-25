<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;

class FillRequest extends FormRequest
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
            "name" => "required|string",
            "email" => [
                "required",
                "email",
                "regex:/^[a-zA-Z0-9._%+-]+@ufca\.edu\.br$/",
                "unique:users,email",
            ]
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O nome é obrigatório.",
            "name.string" => "O nome deve ser um texto.",
            "name.min" => "O nome deve ter pelo menos 3 caracteres.",
            "name.max" => "O nome não pode ultrapassar 255 caracteres.",

            "email.required" => "O e-mail é obrigatório.",
            "email.email" => "Insira um e-mail válido.",
            "email.regex" => "O e-mail deve pertencer ao domínio @ufca.edu.br.",
            "email.unique" => "Este e-mail já está cadastrado.",
        ];
    }
}
