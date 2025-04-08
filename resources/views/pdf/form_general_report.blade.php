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
        <th>Qtd. Respostas</th>
        <th>Status Atual</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $form->title }}</td>
        <td>{{ date('d/m/Y', strtotime($form->date)) }}</td>
        <td>{{ date('d/m/Y', strtotime($form->created_at)) }}</td>
        <td>{{ count($responses) }}</td>
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
  <table style="margin-bottom: 5px;">
    <thead>
      <tr>
        <th colspan="2">Respostas do formulário</th>
      </tr>
    </thead>
  </table>
  @foreach ($responses as $index => $response)
    <table style="text-align: left !important;margin-bottom: 20px;">
      <thead>
        <tr>
          <th width="20%" scope="row" style="text-align: left;">Título da ação:</th>
          <td width="80%">{{ $response->action->title ?? 'Não informado' }}</td>
          <th width="20%" style="text-align: left;">Status atual</th>
          <td width="80%" colspan="3">
            {{ App\Helpers\Status\Status::get_status_response_form($response->was_finished) ?? 'Não informado' }}
          </td>
          {{-- <th></th>
          <td></td> --}}
        </tr>
        <tr>
          <th style="white-space: nowrap; text-align: left;">Data de início</th>
          <td style="white-space: nowrap;">
            {{ date('d/m/Y', strtotime($response->created_at)) ?? 'Não informado' }}</td>
          <th style="white-space: nowrap; text-align: left; text-align: left;">Tipo de ação</th>
          <td style="white-space: nowrap;">{{ $response->type_action ?? 'Não informado' }}</td>
          <th style="white-space: nowrap; text-align: left; text-align: left;">Modalidade da ação</th>
          <td style="white-space: nowrap;">{{ $response->action_modality ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th style="white-space: nowrap; text-align: left;">Nome do coordenador</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_name ?? 'Não informado' }}</td>
          <th style="white-space: nowrap; text-align: left;">Perfil do coordenador</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_profile ?? 'Não informado' }}</td>
          <th style="white-space: nowrap; text-align: left;">Siape do coordenador</th>
          <td style="white-space: nowrap;">{{ $response->coordinator_siape ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th style="white-space: nowrap; text-align: left;">Curso do projeto</th>
          <td style="white-space: nowrap;">{{ $response->course->name ?? 'Não informado' }}</td>
          <th style="white-space: nowrap; text-align: left;">Alcançe interno</th>
          <td style="white-space: nowrap;">{{ $response->qtd_internal_audience ?? 'Não informado' }}</td>
          <th style="white-space: nowrap; text-align: left;">Alacançe externo</th>
          <td style="white-space: nowrap;">{{ $response->qtd_external_audience ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th width="20%" scope="row" style="text-align: left;">Avanços e impactos alcançados</th>
          <td width="80%" colspan="5">{{ $response->advances_extensionist_action ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th width="20%" scope="row" style="text-align: left;">Desenvolvimento de tecnologia social</th>
          <td width="80%" colspan="5">{{ $response->social_technology_development ?? 'Não informado' }}</td>
        </tr>
        <tr>
          <th width="20%" scope="row" style="text-align: left;">Avaliação final</th>
          <td width="80%" colspan="5">{{ $response->instrument_avaliation ?? 'Não informado' }}</td>
        </tr>
        <tr>
          @if (in_array('activitys', $fields))
            <th width="20%" scope="row" style="text-align: left;">Atividades</th>
            <td width="80%" colspan="5" style="padding: 5px">
              <ul style="margin: 0%;">
                @if (isset($response->activitys))
                  @foreach ($response->activitys as $activity)
                    <li style="margin: 5px 0px 5px 0px;"><strong>Atividade: </strong>{{ $activity->activity }}<strong>
                        Local: </strong> {{ $activity->address }}</li>
                  @endforeach
                @else
                  Não informado
                @endif
              </ul>
            </td>
          @endif
        </tr>
        <tr>
          @if (in_array('internal_partners', $fields))
            <th width="20%" style="text-align: left;">Parceiros internos</th>
            <td width="80%" colspan="5" style="padding: 5px">
              <ul style="margin: 0%;">
                @if (isset($response->internal_partners))
                  @foreach ($response->internal_partners as $internal_partner)
                    <li style="margin: 5px 0px 5px 0px;">
                      <strong>Título do parceiro: </strong>{{ $internal_partner->title_action_partner->title }}
                  @endforeach
                @else
                  Não informado
                @endif
              </ul>
            </td>
          @endif
        </tr>
        <tr>
          @if (in_array('external_partners', $fields))
            <th width="20%" style="text-align: left;">Parceiros internos</th>
            <td width="80%" colspan="5" style="padding: 5px">
              <ul style="margin: 0%;">
                @if (isset($response->external_partners))
                  @foreach ($response->external_partners as $external_partner)
                    <li style="margin: 5px 0px 5px 0px;">
                      <strong>Nome do parceiro: </strong>{{ $external_partner->name_partner }}
                      <strong> Tipo de instituição: </strong> {{ $external_partner->institution_type }}
                    </li>
                    <strong> Tipo de parceria: </strong> {{ $external_partner->partnership_type }}</li>
                  @endforeach
                @else
                  Não informado
                @endif
              </ul>
            </td>
          @endif
        </tr>
        <tr>
          @if (in_array('extension_actions', $fields))
            <th width="20%" style="text-align: left;">Ações</th>
            <td width="80%" colspan="5" style="padding: 5px">
              <ul style="margin: 0%;">
                @if (isset($response->extension_actions))
                  @foreach ($response->extension_actions as $extension_action)
                    <li style="margin: 5px 0px 5px 0px;">
                      <strong>Ação: </strong>{{ $extension_action->title_action }}
                      <strong> Escolas Públicas? </strong>
                      {{ $extension_action->its_for_public_schools ? 'Sim' : 'Não' }}
                    </li>
                    <strong> Descrição: </strong> {{ $extension_action->international_description }}</li>
                  @endforeach
                @else
                  Não informado
                @endif
              </ul>
            </td>
          @endif
        </tr>
        <tr>
          @if (in_array('social_medias', $fields))
            <th width="20%" style="text-align: left;">Redes sociais</th>
            <td width="80%" colspan="5" style="padding: 5px">
              <ul style="margin: 0%;">
                @if (isset($response->social_medias))
                  @foreach ($response->social_medias as $social_media)
                    <li style="margin: 5px 0px 5px 0px;">
                      <strong>Nome: </strong>{{ $social_media->name }}
                      <strong> Link </strong> <a href="{{ $social_media->link }}">Acessar</a>
                    </li>
                  @endforeach
                @else
                  Não informado
                @endif
              </ul>
            </td>
          @endif
        </tr>
      </thead>
    </table>
    @if (in_array('images', $fields))
      @if (isset($response->images) && count($response->images) > 0)
        <table>
          <thead>
            <tr>
              <th colspan="2">Imagens</th>
            </tr>
          </thead>
        </table>
        <table width="100%" border="1" cellspacing="0" cellpadding="5"
          style="border-collapse: collapse; margin-bottom: 20px;">
          <thead>
            <tr>
              <th style="text-align: center;">Imagem</th>
              <th style="text-align: left;">Endereço</th>
              <th style="text-align: left;">Data</th>
              <th style="text-align: left;">Descrição</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($response->images as $image)
              <tr>
                <td style="text-align: center;">
                  <img src="{{ $image->base64 }}" style="max-width: 120px; height: auto;" alt="Imagem">
                </td>
                <td>{{ $image->address }}</td>
                <td>{{ date('d/m/Y', strtotime($image->date)) }}</td>
                <td>{{ $image->description }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
      <table>
        <thead>
          <tr>
            <th colspan="2">Imagens não informadas</th>
          </tr>
        </thead>
      </table>
      @endif
    @endif
  @endforeach
  <div style="margin-top: 20px; font-weight: bolder;">
    Emitido por: {{ $user->name }}
</body>

</html>
