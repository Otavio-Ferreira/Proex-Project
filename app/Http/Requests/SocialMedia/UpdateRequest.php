<?php

namespace App\Http\Requests\SocialMedia;

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
            'name' => 'required|string',
            'link' => 'required|string|url',
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "É necessário inserir o nome da rede social.",
            "name.string" => "O campo nome da rede social precisa ser um texto.",
            "link.required" => "É necessário inserir o link da rede social.",
            "link.string" => "O campo link precisa ser um texto.",
            "link.url" => "O campo link precisa estar no formato de url.",
        ];
    }
}
