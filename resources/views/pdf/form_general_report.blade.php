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
          <img src="{{ public_path('assets/img/logo_ufca.jpg') }}" width="100" alt="">
        </th>
        <th width="80%">
          <h2>Relatório de formulário - Proex</h2>
        </th>
      </tr>
      <tr>
        <th colspan="2">Informações do formulário</th>
      </tr>
    </thead>
  </table>
  <table class="content-table" style="margin-bottom: 20px;">
    <thead>
      <tr>
        <th>Título</th>
        <th>Data de criação</th>
        <th>Prazo</th>
        <th>Status Atual</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $form->title }}</td>
        <td>{{ date('d/m/Y', strtotime($form->date)) }}</td>
        <td>{{ date('d/m/Y', strtotime($form->created_at)) }}</td>
        <td>
          {{ App\Helpers\Status\Status::get_status_form($form->status) }}
        </td>
      </tr>
    </tbody>
  </table>
  {{-- <table class="content-table" style="margin-bottom: 20px;">
    <thead>
      <tr>
        <th>Formulário</th>
        {{-- @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                    @foreach ($formularios as $formulario)
                        <th style="text-align: center;">{{ $formulario['formulario'] }}</th>
                    @endforeach
                @endforeach --}}
  {{-- </tr> --}}
  {{-- <tr> --}}
  {{-- <th>Dimensão</th> --}}
  {{-- @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                    @foreach ($formularios as $formulario)
                        <th style="text-align: center;" width="10%">{{ $municipio }}</th>
                    @endforeach
                @endforeach --}}
  {{-- </tr>
  </thead> --}}
  {{-- <tbody> --}}
  {{-- @foreach ($resultadosPorMunicipio->first()->first()['dimensoes'] as $dimensao => $dados)
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
            @endforeach --}}
  {{-- <tr class="table-primary text-white fw-bold"> --}}
  {{-- <td>Grau de maturidade em relação a transformação digital</td> --}}
  {{-- @foreach ($resultadosPorMunicipio as $municipio => $formularios)
                    @foreach ($formularios as $formulario)
                        <td style="text-align: center; font-weight: bolder;">
                            {{ number_format($formulario['somaMedias'], 2) }}</td>
                    @endforeach
                @endforeach 
      </tr>
    </tbody>
  </table> --}}
  <table>
    <thead>
      <tr>
        <th colspan="2">Respostas do formulário</th>
      </tr>
    </thead>
  </table>
  @foreach ($responses as $index => $response)
    <table style="text-align: left;">
      <thead>
        <tr>
          <th width="20%" scope="row">Título da ação:</th>
          <td width="80%">{{ $response->action->title ?? 'Não informado' }}</td>
          <th width="20%">Status atual</th>
          <td width="80%" colspan="4">
            {{ App\Helpers\Status\Status::get_status_response_form($response->was_finished) ?? 'Não informado' }}
          </td>
        </tr>
        <tr widht="100%">
          <th width="15%" style="white-space: nowrap;" scope="row">Data de início</th>
          <td width="15%" style="white-space: nowrap;">
            {{ date('d/m/Y', strtotime($response->created_at)) ?? 'Não informado' }}</td>
          <th width="15%" style="white-space: nowrap;">Tipo de ação</th>
          <td width="15%" style="white-space: nowrap;">{{ $response->type_action ?? 'Não informado' }}</td>
          <th width="20%" style="white-space: nowrap;">Modalidade da ação</th>
          <td width="20%" style="white-space: nowrap;" >{{ $response->action_modality ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th style="white-space: nowrap;">Nome do coordenador</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_name ?? 'Não informado' }}</td>
          <th style="white-space: nowrap;">Perfil do coordenador</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_profile ?? 'Não informado' }}</td>
          <th style="white-space: nowrap;">Siape do coordenador</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_siape ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th style="white-space: nowrap;">Curso do projeto</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_course ?? 'Não informado' }}</td>
          <th style="white-space: nowrap;">Alcançe interno</th>
          <td style="white-space: nowrap;">{{ $response->qtd_internal_audience ?? 'Não informado' }}</td>
          <th style="white-space: nowrap;">Alacançe externo</th>
          <td style="white-space: nowrap;">{{ $response->qtd_external_audience ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th width="20%">Avanços e impactos alcançados</th>
          <td width="80%" colspan="5">{{ $response->advances_extensionist_action ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th width="20%">Desenvolvimento de tecnologia social</th>
          <td width="80%" colspan="5">{{ $response->social_technology_development ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th width="20%">Avaliação final</th>
          <td width="80%" colspan="5">{{ $response->instrument_avaliation ?? 'Não informado' }}</td>
        </tr>
      </thead>
    </table>
    {{-- <table class="content-table" style="margin-bottom: 20px;">
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
        </table> --}}
  @endforeach
  <div style="margin-top: 20px; font-weight: bolder;">
    {{-- Emitido por: {{ $usuario->name }} --}}
  </div>
</body>

</html>
