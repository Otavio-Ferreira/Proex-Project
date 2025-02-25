<?php

namespace App\Http\Requests\Spatie;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "name" => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "É necessário inserir um nome.",
            "name.string" => "É necessário inserir um nome válido."
        ];
    }
}
