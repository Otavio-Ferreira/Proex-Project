<?php

namespace App\Http\Requests\Projetcs;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
    public function rules()
    {

        return [
            'title' => 'required|string',
            'id_atividade' => 'required|string',
            'id_projeto' => 'required|string',
            'year' => 'required|integer',
            'type' => 'required|string|exists:parameters,value',
            'modality' => 'required|string|exists:parameters,value',
            'thematic_area' => 'required|string|exists:parameters,value',
            'course' => 'required|uuid|exists:courses,id',
            'teacher' => 'required|uuid|exists:users,id',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|integer|in:0,1,2',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O campo título é obrigatório.',
            'title.string' => 'O título deve ser um texto.',

            'id_atividade.required' => 'O campo id da atividade é obrigatório.',
            'id_atividade.string' => 'O id da atividade deve ser um texto.',

            'id_projeto.required' => 'O campo id do projeto é obrigatório.',
            'id_projeto.string' => 'O id do projeto deve ser um texto.',

            'year.required' => 'O ano é obrigatório.',
            'year.integer' => 'O ano deve ser um número inteiro.',

            'type.required' => 'O campo tipo é obrigatório.',
            'type.string' => 'O tipo deve ser um texto.',
            'type.exists' => 'O tipo deve existir na nossa base de dados.',

            'modality.required' => 'O campo modalidade é obrigatório.',
            'modality.string' => 'A modalidade deve ser um texto.',
            'modality.exists' => 'A modalidade deve existir na nossa base de dados.',

            'thematic_area.required' => 'O campo área temática é obrigatório.',
            'thematic_area.string' => 'A área temática deve ser um texto.',
            'thematic_area.exists' => 'A área temática deve existir na nossa base de dados.',

            'course.required' => 'O curso é obrigatório.',
            'course.uuid' => 'O curso deve ser um UUID válido.',
            'course.exists' => 'O curso selecionado não existe.',

            'teacher.required' => 'O professor é obrigatório.',
            'teacher.uuid' => 'O professor deve ser um UUID válido.',
            'teacher.exists' => 'O professor selecionado não existe.',

            'start_date.required' => 'A data de início é obrigatória.',
            'start_date.date' => 'A data de início deve ser uma data válida.',
            'start_date.before_or_equal' => 'A data de início não pode ser posterior à data de término.',

            'end_date.required' => 'A data de término é obrigatória.',
            'end_date.date' => 'A data de término deve ser uma data válida.',
            'end_date.after_or_equal' => 'A data de término não pode ser anterior à data de início.',

            'status.required' => 'O status é obrigatório.',
            'status.integer' => 'O status deve ser um número inteiro.',
            'status.in' => 'O status deve ser 0 (Rascunho), 1 (Ativo) ou 2 (Concluído).',
        ];
    }
}
