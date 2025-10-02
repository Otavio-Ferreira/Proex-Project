@extends('templates.template')

@section('styles')
  <style>
    .circleGraph {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: conic-gradient(#4caf50 0% 0%,
          /* Inicial */
          #ccc 0% 100%);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .inner-circle {
      width: 70px;
      height: 70px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .progress-value {
      font-size: 10px;
      font-weight: bold;
    }
  </style>
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-md">
          <div class="page-pretitle">
            <a href="{{ route('projects.my') }}">Meus trabalhos</a> /
            <a href="{{ route('response.index', $response->id) }}">Relatório</a>
          </div>
          <h2 class="page-title">
            Relatório de Trabalho
          </h2>
        </div>
        <div class="d-flex align-items-center col-sm-12 col-md-auto">
          <div class="btn-list">
            <a href="{{route('projects.my')}}" class="btn btn-cyan">Voltar</a>
            <a href="{{route('response.report', $response->id)}}" class="btn btn-primary">Baixar relatório</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    <div class="col-12 col-md-4">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-4">
              <div class="circleGraph" data-value="{{ $progress }}">
                <div class="inner-circle">
                  <span class="progress-value"></span>%
                </div>
              </div>
            </div>
            <div class="col-8">
              <p class="m-0 text-muted">Seu progresso em relação ao preenchimento do relatório.</p>
            </div>
          </div>
        </div>
      </div>
      @if (isset($response->comment->comment) && $form->status == 1 && $response->was_finished == 2)
        <div class="alert alert-danger mb-3">
          <h4>Observações:</h4>
          {{ $response->comment->comment }}
        </div>
      @endif
      <div class="card">
        <div class="card-body">
          @if ($form->status == 1)
            @if ($response->was_finished == 0)
              Esse formulário está ativo no momento. O prazo para o seu preenchimento é até o dia
              {{ date('d/m/Y', strtotime($form->date)) }}.
              <div class="w-100 d-flex justify-content-end mt-2">
                <a href="{{ route('response.start', $response->id) }}" class="btn btn-danger w-100">Preencher
                  relatório</a>
              </div>
            @elseif($response->was_finished == 1)
              Você ja enviou esse relatório, aguarde ele ser aprovado.
            @elseif($response->was_finished == 2)
              Esse formulário foi aberto novamente pois há alterações para serem feitas. O prazo para o seu preenchimento
              é até o dia
              {{ date('d/m/Y', strtotime($form->date)) }}.
              <div class="w-100 d-flex justify-content-end mt-2">
                <a href="{{ route('response.start', $response->id) }}" class="btn btn-danger w-100">Corrigir
                  relatório</a>
              </div>
            @else
              Você ja enviou esse relatório, e ele foi aprovado.
            @endif
          @else
            Esse formulario está indisponível para alterações.
          @endif
        </div>
      </div>
    </div>
    <div class="col-12 col-md-8 mb-3 mb-md-0 overflow-auto" style="height: calc(100vh - 300px);">
      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-body row">
          <div class="col-12">
            <h4 class="mb-0">Título do trabalho</h4>
            <p>{{ $response->project->title ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Tipo da ação</h4>
            <p>{{ $response->project->type ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Área temática</h4>
            <p>{{ $response->project->thematic_area ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-12">
            <h4 class="mb-0">Modalidade da ação</h4>
            <p>{{ $response->project->modality ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Id da atividade</h4>
            <p>{{ $response->project->id_atividade ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Id do projeto</h4>
            <p>{{ $response->project->id_projeto ?? 'Não enviado' }}</p>
          </div>
          <hr class="mb-3">
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Nome do coordenador</h4>
            <p>{{ $response->user->name ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Perfil do coordenador</h4>
            <p>{{ $response->user->persons->coordinator_profile ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Siape do coordenador</h4>
            <p>{{ $response->user->persons->coordinator_siape ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="mb-0">Curso do coordenador</h4>
            <p>{{ $response->user->persons->course->name ?? 'Não enviado' }}</p>
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Total do público interno à UFCA beneficiado</h4>
            <p>{{ $response->qtd_internal_audience ?? 'Não enviado' }}</p>
          </div>
          <div class="col-12">
            <h4 class="mb-0">Total do público externo à UFCA beneficiado</h4>
            <p>{{ $response->qtd_external_audience ?? 'Não enviado' }}</p>
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Detalhamento das atividades</h4>
            @if ($response->activitys->count() > 0)
              <x-table.table tableClass="table-vcenter card-table table-striped">
                <x-slot:ths>
                  <th>Atividade</th>
                  <th>Local</th>
                </x-slot:ths>
                <x-slot:trs>
                  @foreach ($response->activitys as $activity)
                    <tr>
                      <td>{{ $activity->activity }}</td>
                      <td>{{ $activity->address }}</td>
                    </tr>
                  @endforeach
                </x-slot:trs>
              </x-table.table>
            @else
              <p>
                Não enviado
              </p>
            @endif
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Descrição dos avanços alcançados e impactos da ação extensionista</h4>
            <p>{{ $response->advances_extensionist_action ?? 'Não enviado' }}</p>
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Parcerias Internas</h4>
            @if ($response->internal_partners->count() > 0)
              <x-table.table tableClass="table-vcenter card-table table-striped">
                <x-slot:ths>
                  <th>Título da ação parceira</th>
                  <th width="5%"></th>
                </x-slot:ths>
                <x-slot:trs>
                  @foreach ($response->internal_partners as $internal_partner)
                    <tr>
                      <td>{{ $internal_partner->title_action_partner->title }}</td>
                    </tr>
                  @endforeach
                </x-slot:trs>
              </x-table.table>
            @else
              <p>
                Não enviado
              </p>
            @endif
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Parcerias Externas</h4>
            @if ($response->external_partners->count() > 0)
              <x-table.table tableClass="table-vcenter card-table table-striped">
                <x-slot:ths>
                  <th>Nome do parceiro</th>
                  <th>Tipo de instituição</th>
                  <th>Tipo de parceria</th>
                </x-slot:ths>
                <x-slot:trs>
                  @foreach ($response->external_partners as $externalPartner)
                    <tr>
                      <td>{{ $externalPartner->name_partner }}</td>
                      <td>{{ $externalPartner->institution_type }}</td>
                      <td>{{ $externalPartner->partnership_type }}</td>
                    </tr>
                  @endforeach
                </x-slot:trs>
              </x-table.table>
            @else
              <p>
                Não enviado
              </p>
            @endif
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Ações vinculadas ao {{strtolower($response->project->type)}} de extensão</h4>
            @if ($response->extension_actions->count() > 0)
              <x-table.table tableClass="table-vcenter card-table table-striped">
                <x-slot:ths>
                  <th>Ação</th>
                  <th>Escolas públicas?</th>
                  <th>Descrição internacional</th>
                </x-slot:ths>
                <x-slot:trs>
                  @foreach ($response->extension_actions as $extensionActions)
                    <tr>
                      <td>{{ $extensionActions->title_action }}</td>
                      <td>{{ $extensionActions->its_for_public_schools == 1 ? 'Sim' : 'Não' }}</td>
                      <td>{{ $extensionActions->international_description }}</td>
                    </tr>
                  @endforeach
                </x-slot:trs>
              </x-table.table>
            @else
              <p>
                Não enviado
              </p>
            @endif
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">A ação atuou com o desenvolvimento de alguma tecnologia social? Se sim, descreva</h4>
            <p>{{ $response->social_technology_development ?? 'Não enviado' }}</p>
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Redes sociais</h4>
            @if ($response->social_medias->count() > 0)
              <x-table.table tableClass="table-vcenter card-table table-striped">
                <x-slot:ths>
                  <th>Nome</th>
                  <th>Link</th>
                </x-slot:ths>
                <x-slot:trs>
                  @foreach ($response->social_medias as $socialMedia)
                    <tr>
                      <td>{{ $socialMedia->name }}</td>
                      <td><a href="{{ $socialMedia->link }}">Acessar</a></td>
                    </tr>
                  @endforeach
                </x-slot:trs>
              </x-table.table>
            @else
              <p>
                Não enviado
              </p>
            @endif
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Imagens das atividades realizadas</h4>
            @if ($response->images->count() > 0)
              <x-table.table tableClass="table-vcenter card-table table-striped">
                <x-slot:ths>
                  <th>Imagem</th>
                  <th>Local</th>
                  <th>Data</th>
                  <th>Descrição</th>
                </x-slot:ths>
                <x-slot:trs>
                  @foreach ($response->images as $image)
                    <tr>
                      <td><a href="{{ asset($image->image) }}" target="_blank">Visualizar</a></td>
                      <td>{{ $image->address }}</td>
                      <td>{{ $image->date }}</td>
                      <td>{{ $image->description }}</td>
                    </tr>
                  @endforeach
                </x-slot:trs>
              </x-table.table>
            @else
              <p>
                Não enviado
              </p>
            @endif
          </div>
          <hr class="mb-3">
          <div class="col-12">
            <h4 class="mb-0">Avaliação</h4>
            <p>{{ $response->instrument_avaliation ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const circles = document.querySelectorAll('.circleGraph');

      circles.forEach(function(circle) {
        let value = parseInt(circle.getAttribute('data-value')) || 0;
        let maxValue = 8; // Defina o valor máximo
        let percentage = (value / maxValue) * 100; // Converte para percentual

        // Aplica o progresso ao estilo de background
        circle.style.background = `conic-gradient(#066FD1 ${percentage}%, #ccc ${percentage}% 100%)`;

        // Atualiza o valor de progresso dentro do círculo, se existir
        let progressText = circle.querySelector('.progress-value');
        if (progressText) {
          progressText.textContent = percentage.toFixed(0).replace('.', ',');
        }
      });
    });
  </script>
@endsection
