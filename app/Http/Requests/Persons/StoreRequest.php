<?php

namespace App\Http\Requests\Persons;

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
            'coordinator_name' => 'required|string',
            'coordinator_profile' => 'required|string|in:Docente,Técnico Administrativo,Discente',
            'coordinator_siape' => 'required|integer',
            'coordinator_course' => 'required|exists:courses,name',
        ];
    }

    public function messages()
    {
        return [
            'coordinator_name.required' => 'O campo "Nome do Coordenador" é obrigatório.',
            'coordinator_name.string' => 'O campo "Nome do Coordenador" deve ser uma string.',

            'coordinator_profile.required' => 'O campo "Perfil do Coordenador" é obrigatório.',
            'coordinator_profile.string' => 'O campo "Perfil do Coordenador" deve ser uma string.',
            'coordinator_profile.in' => 'O "Perfil do Coordenador" deve ser "Docente", "Técnico Administrativo" ou "Discente".',

            'coordinator_siape.required' => 'O campo "SIAPE do Coordenador" é obrigatório.',
            'coordinator_siape.integer' => 'O campo "SIAPE do Coordenador" deve ser um número inteiro.',

            'coordinator_course.required' => 'O campo "Curso do Coordenador" é obrigatório.',
            'coordinator_course.exists' => 'O "Curso do Coordenador" informado não existe.',
        ];
    }
}
