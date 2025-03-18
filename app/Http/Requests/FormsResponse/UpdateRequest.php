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

        if (request()->input('status') == 1) {
            $rules['input_comment'] = ['required', 'string'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'status.required' => 'O campo status é obrigatório.',
            'status.integer' => 'O campo status precisa ser um número.',
            'status.in' => 'O campo status precis ser 2 ou 4.',

            'input_comment.required' => 'O campo do comentário é obrigatório.',
            'input_comment.string' => 'O campo do comentário deve ser uma string.',
        ];
    }
}
