<?php

namespace App\Http\Requests\Forms;

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
            'title' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|integer|in:0,1'
        ];
    }

    public function messages()
    {
        return [
            "title.required" => "É necessário inserir um título.",
            "title.text" => "O campo title precisa ser um texto.",
            "date.required" => "É necessário inserir uma data.",
            "date.data" => "O campo data precisa ser válido .",
            "status.required" => "É necessário escolher um status",
            "status.integer" => "O campo status precisa ser válido.",
            "status.in" => "O campo status deve ser 0 ou 1.",
        ];
    }
}
