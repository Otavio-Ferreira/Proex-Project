<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'address' => 'required|string',
            'date' => 'required|date',
            'description' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            "image.required" => "É necessário enviar uma imagem.",
            "image.image" => "O arquivo enviado deve ser uma imagem.",
            "image.mimes" => "A imagem deve estar nos formatos: jpeg, jpg ou png.",
            "image.max" => "A imagem não pode ter mais de 2MB.",

            "address.required" => "É necessário inserir um endereço.",
            "address.string" => "O campo endereço precisa ser um texto.",

            "date.required" => "É necessário inserir uma data.",
            "date.date" => "O campo data precisa ser válido.",

            "description.required" => "É necessário inserir uma descrição.",
            "description.string" => "O campo descrição precisa ser um texto.",
        ];
    }
}
