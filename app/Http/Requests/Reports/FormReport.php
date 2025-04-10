<?php

namespace App\Http\Requests\Reports;

use Illuminate\Foundation\Http\FormRequest;

class FormReport extends FormRequest
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
    public function rules(): array
    {
        return [
            'status' => ['required', 'array', 'min:1'],
            'status.*' => ['in:0,1,2,3,4'],
            'additional_fields' => ['nullable', 'array'],
            'additional_fields.*' => ['string'],
            'all' => ['required', 'in:true,false'],
            'projects' => ['required_if:all,false', 'array'],
            'projects.*' => ['uuid', 'exists:forms_responses,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Selecione pelo menos um status.',
            'status.array' => 'O status deve ser um array válido.',
            'status.*.in' => 'Status inválido selecionado.',
            'additional_fields.array' => 'Os campos adicionais devem ser um array.',
            'additional_fields.*.string' => 'Cada campo adicional deve ser uma string válida.',
            'all.required' => 'Escolha entre buscar todas as respostas ou respostas individuais.',
            'all.in' => 'O campo de escolha entre todas as respostas ou respostas individuais deve ser verdadeiro ou falso.',
            'projects.required_if' => 'Os projetos são obrigatórios quando foi escolhido buscar respostas individuais.',
            'projects.array' => 'Os projetos devem ser enviados em um array válido.',
            'projects.*.uuid' => 'O ID do projeto deve ser um UUID válido.',
            'projects.*.exists' => 'Um dos projetos enviados não existe.',
        ];
    }
}
