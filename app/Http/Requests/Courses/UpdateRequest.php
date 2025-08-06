<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            "name" => "required|string",
            "status" => "required|boolean"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O campo nome é obrigatório.",
            "name.string" => "O campo nome deve ser válido.",
            "status.required" => "O campo status é obrigatório.",
            "status.boolean" => "O campo status deve ser válido."
        ];
    }
}
