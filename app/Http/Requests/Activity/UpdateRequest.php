<?php

namespace App\Http\Requests\Activity;

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
            'activity' => 'required|string',
            'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            "activity.required" => "É necessário inserir uma atividade.",
            "activity.string" => "O campo atividade precisa ser um texto.",
            "address.required" => "É necessário inserir um endereço",
            "address.string" => "O campo endereço precisa ser um texto.",
        ];
    }
}
