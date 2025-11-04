<?php

namespace App\Http\Requests\FormsResponse;

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
            'status' => 'required|integer|in:2,4',
        ];

        if (request()->input('status') == 2) {
            $rules['comment'] = ['required', 'string'];
        }

        if (request()->input('status') == 4) {
            $rules['finished'] = ['required', 'in:0,1'];
        }



        return $rules;
    }

    public function messages()
    {
        return [
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status precisa ser um número.',
            'status.in' => 'O campo status precis ser 2 ou 4.',

            'comment.required' => 'O campo do comentário é obrigatório.',
            'comment.string' => 'O campo do comentário deve ser uma string.',

            'finished.required' => 'É obrigatório escolher finalizar ou não a ação.',
            'finished.in' => 'É obrigatório escolher finalizar ou não a ação aaaaa.',
        ];
    }
}
