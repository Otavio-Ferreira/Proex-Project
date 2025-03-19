<?php

namespace App\Http\Requests\ExtencionAction;

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
        $rules = [
            'title_action' => 'required|string',
            'its_for_public_schools' => 'required|integer|in:0,1',
        ];

        if (request()->input('its_for_public_schools') == 1) {
            $rules['international_description'] = ['required', 'string'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            "title_action.required" => "É necessário inserir uma ação.",
            "title_action.string" => "O campo ação precisa ser um texto.",

            "its_for_public_schools.required" => "É responder se a ação é voltada para as escolas públicas.",
            "its_for_public_schools.integer" => "O campo ação é voltada para as escolas públicas precisa ser válido.",
            "its_for_public_schools.in" => "O campo ação é voltada para as escolas públicas precisa ser 0 ou 1.",

            "international_description.required" => "O necessário inserir uma descrição.",
            "international_description.string" => "O campo descrição deve ser um texto.",
        ];
    }
}
