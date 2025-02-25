<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Relatório</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: sans-serif;
        }

        td,
        th {
            font-size: 12px;
            border: 1px solid black;
            padding: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table th {
            text-align: center;
        }

        .content-table th,
        .content-table td {
            text-align: left;
        }

        .section-title {
            background-color: lightblue;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <table class="header-table">
        <thead>
            <tr>
                <th width="20%">
                    <img src="{{ public_path('assets/img/alternativa.png') }}" width="100" alt="">
                </th>
                <th width="80%">
                    <h2>Relatório de diagnóstico</h2>
                </th>
            </tr>
            <tr>
                <th colspan="2">Resultado geral</th>
            </tr>
        </thead>
    </table>
    <table class="content-table" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Município</th>
                <th>Região</th>
                <th>Extensão territorial</th>
                <th>PIB</th>
                <th>PIB per capita</th>
                <th>Número de negócios</th>
                <th>Número de empregos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($municipios as $municipio)
                <tr>
                    <td>{{ $municipio->nome }}</td>
                    <td>{{ $municipio->regiao }}</td>
                    <td>{{ $municipio->extensao_territorial }}</td>
                    <td>{{ $municipio->pib }}</td>
                    <td>{{ $municipio->pib_per_capita }}</td>
                    <td>{{ $municipio->numero_negocios }}</td>
                    <td>{{ $municipio->numero_empregos }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table class="content-table" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Formulário</th>
                @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                    @foreach ($formularios as $formulario)
                        <th style="text-align: center;">{{ $formulario['formulario'] }}</th>
                    @endforeach
                @endforeach
            </tr>
            <tr>
                <th>Dimensão</th>
                @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                    @foreach ($formularios as $formulario)
                        <th style="text-align: center;" width="10%">{{ $municipio }}</th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($resultadosPorMunicipio->first()->first()['dimensoes'] as $dimensao => $dados)
                @if ($dimensao !== 'mediaDasMedias')
                    <tr>
                        <td>{{ $dimensao }}</td>
                        @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                            @foreach ($formularios as $formulario)
                                <td style="text-align: center;">
                                    {{ isset($formulario['dimensoes'][$dimensao]) ? number_format($formulario['dimensoes'][$dimensao]['media_ponderada'], 2) : '-' }}
                                </td>
                            @endforeach
                        @endforeach
                    </tr>
                @endif
            @endforeach
            <tr class="table-primary text-white fw-bold">
                <td>Grau de maturidade em relação a transformação digital</td>
                @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                    @foreach ($formularios as $formulario)
                        <td style="text-align: center; font-weight: bolder;">
                            {{ number_format($formulario['somaMedias'], 2) }}</td>
                    @endforeach
                @endforeach
            </tr>
        </tbody>
    </table>
    @foreach ($respostas_detalhadas as $index => $resposta_detalhada)
        <table class="header-table">
            <thead>
                <tr>
                    <th colspan="2">{{ explode('/', $index)[0] }}</th>
                </tr>
            </thead>
        </table>
        <table class="content-table" style="margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>Dimensão</th>
                    <th>Dispositivo</th>
                    <th>Requisito</th>
                    <th>Descrição</th>
                    <th>Nota</th>
                    <th>Peso</th>
                    <th>Evidência</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resposta_detalhada as $resposta)
                    <tr>
                        <td>{{ $resposta->titulo_dimensao }}</td>
                        <td>{{ $resposta->dispositivo }}</td>
                        <td>{{ $resposta->requisito }}</td>
                        <td>{{ $resposta->descricao }}</td>
                        <td>{{ $resposta->nota }}</td>
                        <td>{{ $resposta->peso }}</td>
                        <td>{{ $resposta->evidencia }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    <div style="margin-top: 20px; font-weight: bolder;">
        Emitido por: {{ $usuario->name }}
    </div>
</body>

</html>
