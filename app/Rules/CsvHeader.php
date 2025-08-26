<?php

namespace App\Rules;

// A interface 'Rule' foi removida daqui, pois não é mais necessária com este formato.
use Closure;
use Illuminate\Contracts\Validation\ValidationRule; // Usando a interface mais moderna

// A implementação da interface 'Rule' foi removida da declaração da classe.
class CsvHeader implements ValidationRule
{
    /**
     * As colunas esperadas no cabeçalho.
     *
     * @var array
     */
    protected $expectedHeaders;

    /**
     * Cria uma nova instância da regra.
     *
     * @param array $expectedHeaders
     */
    public function __construct(array $expectedHeaders)
    {
        $this->expectedHeaders = $expectedHeaders;
    }

    /**
     * Valida o cabeçalho do arquivo CSV.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // $value aqui é o arquivo enviado (UploadedFile)
        $handle = fopen($value->getRealPath(), 'r');

        if (!$handle) {
            $fail('Não foi possível abrir o arquivo para validação.');
            return;
        }

        // Detecta o delimitador (vírgula ou ponto e vírgula)
        $firstLine = fgets($handle);
        $delimiter = substr_count($firstLine, ';') > substr_count($firstLine, ',') ? ';' : ',';
        
        // Volta para o início do arquivo e lê o cabeçalho com o delimitador correto
        rewind($handle);
        $csvHeaders = fgetcsv($handle, 0, $delimiter);
        fclose($handle);

        if ($csvHeaders === false) {
            $fail('Não foi possível ler o cabeçalho do arquivo CSV.');
            return;
        }

        // Normaliza os cabeçalhos para comparação (remove espaços e converte para minúsculas)
        $normalizedCsvHeaders = array_map('trim', array_map('strtolower', $csvHeaders));
        $normalizedExpectedHeaders = array_map('trim', array_map('strtolower', $this->expectedHeaders));

        // Verifica se todas as colunas esperadas estão presentes no arquivo
        $missingHeaders = array_diff($normalizedExpectedHeaders, $normalizedCsvHeaders);

        if (!empty($missingHeaders)) {
            $fail('O cabeçalho do arquivo CSV é inválido. Colunas faltando: ' . implode(', ', $missingHeaders));
        }
    }
}