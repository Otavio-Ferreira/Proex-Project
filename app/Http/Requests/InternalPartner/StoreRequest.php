<?php

namespace App\Http\Requests\InternalPartner;

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
            'title_partner' => 'required|uuid|exists:projects,id'
        ];
    }

    public function messages()
    {
        return [
            "title_partner.required" => "É necessário inserir uma ação parceira.",
            "title_partner.uuid" => "O campo título da ação parceira precisa ser válido.",
            "title_partner.exists" => "O campo título da ação parceira precisa existir em nossa base.",
        ];
    }
}
