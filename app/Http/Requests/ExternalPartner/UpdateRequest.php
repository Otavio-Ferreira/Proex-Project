<?php

namespace App\Http\Requests\ExternalPartner;

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
            'name_partner' => 'required|string',
            'institution_type' => 'required|string|in:Movimento Social Organizado (MSO), Privado (PR),Público Municipal (PM), Público Estadual (PE), Público Federal (PF)',
            'partnership_type' => 'required|string|in:Cooperação (CP), Convênio (CV), Contrato (CT)'
        ];
    }

    public function messages()
    {
        return [
            "name_partner.required" => "É necessário inserir um nome para o parceiro.",
            "name_partner.string" => "O campo nome do parceiro precisa ser um texto.",

            "institution_type.required" => "É necessário inserir um tipo de instituição.",
            "institution_type.string" => "O campo tipo de instituição precisa ser um texto.",
            "institution_type.in" => "O campo tipo de instituição precisa ser válido",

            "partnership_type.required" => "É necessário inserir um tipo de parceria.",
            "partnership_type.string" => "O campo tipo de parceria precisa ser um texto.",
            "partnership_type.in" => "O campo tipo de parceria precisa ser válido.",
        ];
    }
}
