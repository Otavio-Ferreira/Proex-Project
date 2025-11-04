<?php

namespace App\Http\Requests\Projetcs;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CsvHeader;

class ImportRequest extends FormRequest
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
        // Define as colunas que esperamos encontrar no cabeçalho do CSV.
        $expectedHeaders = [
            'ID Atividade',
            'ID Projeto',
            'Título',
            'Coordenador',
            'SIAPE',
            'Email',
            'Centro/Departamento',
            'Data Inicio',
            'Data Fim',
            'Ano',
            'Tipo Ação',
            'Area Tematica',
            'Modalidade'
        ];

        return [
            'csv' => [
                'required',
                'file',
                'mimes:csv,txt',
                // Aqui usamos nossa regra customizada para validar o cabeçalho.
                new CsvHeader($expectedHeaders)
            ],
        ];
    }

    /**
     * Mensagens de erro customizadas para as regras de validação.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'csv.required' => 'O campo de arquivo CSV é obrigatório.',
            'csv.file'     => 'O item enviado deve ser um arquivo.',
            'csv.mimes'    => 'O arquivo deve ser do tipo CSV.',
        ];
    }
}
