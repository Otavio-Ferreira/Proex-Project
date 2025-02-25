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
                <th colspan="2">{{ $itens_respostas->municipios->nome }} - {{ $itens_respostas->municipios->regiao }}
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
                <th>Núméro de negócios</th>
                <th>Núméro de empregos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $itens_respostas->municipios->nome }}</td>
                <td>{{ $itens_respostas->municipios->regiao }}</td>
                <td>{{ $itens_respostas->municipios->extensao_territorial }}</td>
                <td>{{ $itens_respostas->municipios->pib }}</td>
                <td>{{ $itens_respostas->municipios->pib_per_capita }}</td>
                <td>{{ $itens_respostas->municipios->numero_negocios }}</td>
                <td>{{ $itens_respostas->municipios->numero_empregos }}</td>
            </tr>
        </tbody>
    </table>
    <table class="content-table" style="margin-bottom: 20px;">
        <thead>
            <tr>
                <th>Dimensão</th>
                <th width="5px">Média</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agrupadasPorDimensao as $resposta)
                <tr>
                    <td>{{ $resposta['titulo_dimensao'] }}</td>
                    <td style="text-align: center;">{{ $resposta['media_ponderada'] }}</td>
                </tr>
            @endforeach
            <tr class="section-title">
                <td>Grau de maturidade em relação a transformação digital</td>
                <td style="text-align: center;">{{ $somaMedias }}</td>
            </tr>
            @isset($maturidade->descricao)
                <tr>
                    <td>{{ $maturidade->descricao }}</td>
                </tr>
            @endisset
        </tbody>
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
        @foreach ($respostas_detalhadas as $titulo => $resposta_detalhada)
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
        @endforeach
    </table>
    <div style="padding: 10px 17px; font-size: 12px; font-weight: bold;">
        Emitido por: {{ $usuario->name }}
    </div>
</body>

</html>
