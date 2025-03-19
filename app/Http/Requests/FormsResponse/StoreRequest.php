<?php

namespace App\Http\Requests\FormsResponse;

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
            'title_action' => 'nullable|uuid|exists:projects,id',
            'type_action' => 'nullable|string|in:Programa,Projeto',
            'action_modality' => 'nullable|string|in:UFCA Itinerante,Ampla Concorrência,PROPE',
            'coordinator_name' => 'nullable|string',
            'coordinator_profile' => 'nullable|string|in:Docente,Técnico Administrativo,Discente',
            'coordinator_siape' => 'nullable|integer',
            'coordinator_course' => 'nullable|uuid|exists:courses,id',
            'qtd_internal_audience' => 'nullable|integer',
            'qtd_external_audience' => 'nullable|integer',
            'advances_extensionist_action' => 'nullable|string',
            'social_technology_development' => 'nullable|string',
            'instrument_avaliation' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            // 'title_action.required' => 'O campo "Título da Ação" é obrigatório.',
            'title_action.uuid' => 'O campo "Título da Ação" deve ser um UUID válido.',
            'title_action.exists' => 'O "Título da Ação" informado não existe.',

            // 'type_action.required' => 'O campo "Tipo da Ação" é obrigatório.',
            'type_action.string' => 'O campo "Tipo da Ação" deve ser uma string.',
            'type_action.in' => 'O campo "Tipo da Ação" deve ser "Programa" ou "Projeto".',

            // 'action_modality.required' => 'O campo "Modalidade da Ação" é obrigatório.',
            'action_modality.string' => 'O campo "Modalidade da Ação" deve ser uma string.',
            'action_modality.in' => 'A "Modalidade da Ação" deve ser "UFCA Itinerante", "Ampla Concorrência" ou "PROPE".',

            // 'coordinator_name.required' => 'O campo "Nome do Coordenador" é obrigatório.',
            'coordinator_name.string' => 'O campo "Nome do Coordenador" deve ser uma string.',

            // 'coordinator_profile.required' => 'O campo "Perfil do Coordenador" é obrigatório.',
            'coordinator_profile.string' => 'O campo "Perfil do Coordenador" deve ser uma string.',
            'coordinator_profile.in' => 'O "Perfil do Coordenador" deve ser "Docente", "Técnico Administrativo" ou "Discente".',

            // 'coordinator_siape.required' => 'O campo "SIAPE do Coordenador" é obrigatório.',
            'coordinator_siape.integer' => 'O campo "SIAPE do Coordenador" deve ser um número inteiro.',

            // 'coordinator_course.required' => 'O campo "Curso do Coordenador" é obrigatório.',
            'coordinator_course.uuid' => 'O campo "Curso do Coordenador" deve ser um UUID válido.',
            'coordinator_course.exists' => 'O "Curso do Coordenador" informado não existe.',

            // 'qtd_internal_audience.required' => 'O campo "Quantidade de Público Interno" é obrigatório.',
            'qtd_internal_audience.integer' => 'O campo "Quantidade de Público Interno" deve ser um número inteiro.',

            // 'qtd_external_audience.required' => 'O campo "Quantidade de Público Externo" é obrigatório.',
            'qtd_external_audience.integer' => 'O campo "Quantidade de Público Externo" deve ser um número inteiro.',

            // 'advances_extensionist_action.required' => 'O campo "Avanços da Ação Extensionista" é obrigatório.',
            'advances_extensionist_action.string' => 'O campo "Avanços da Ação Extensionista" deve ser uma string.',

            // 'social_technology_development.required' => 'O campo "Desenvolvimento de Tecnologia Social" é obrigatório.',
            'social_technology_development.string' => 'O campo "Desenvolvimento de Tecnologia Social" deve ser uma string.',

            // 'instrument_avaliation.required' => 'O campo "Instrumento de Avaliação" é obrigatório.',
            'instrument_avaliation.string' => 'O campo "Instrumento de Avaliação" deve ser uma string.',
        ];
    }
}
