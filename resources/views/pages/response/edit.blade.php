@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-md">
          <div class="page-pretitle">
            <a href="{{ route('forms.create') }}">Formulários</a> /
            <a href="{{ route('forms.show', $response->forms_id) }}">Detalhes</a> /
            <a href="{{ route('response.edit', $response->id) }}">Resposta</a>
          </div>
          <h2 class="page-title">
            Resposta
          </h2>
        </div>
        <div class="d-flex align-items-center col-sm-12 col-md-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    <div class="col-12 col-md-9 mb-3 mb-md-0 overflow-auto" style="height: calc(100vh - 300px);">
      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Título da ação de extensão</h3>
        </div>
        <div class="card-body">
          <div class="">
            <h4 class="mb-0">Título da ação</h4>
            <p>{{ $response->action->title ?? 'Não enviado' }}</p>
          </div>
          <div class="">
            <h4 class="mb-0">Tipo da ação</h4>
            <p>{{ $response->type_action ?? 'Não enviado' }}</p>
          </div>
          <div class="">
            <h4 class="mb-0">Modalidade da ação</h4>
            <p>{{ $response->action_modality ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Dados do coordenador/tutor da ação de extensão</h3>
        </div>
        <div class="card-body">
          <div class="">
            <h4 class="mb-0">Nome</h4>
            <p>{{ $response->coordinator_name ?? 'Não enviado' }}</p>
          </div>
          <div class="">
            <h4 class="mb-0">Perfil</h4>
            <p>{{ $response->coordinator_profile ?? 'Não enviado' }}</p>
          </div>
          <div class="">
            <h4 class="mb-0">SIAPE</h4>
            <p>{{ $response->coordinator_siape ?? 'Não enviado' }}</p>
          </div>
          <div class="">
            <h4 class="mb-0">Curso</h4>
            <p>{{ $response->course->name ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Detalhamento de atividades</h3>
        </div>
        <div class="card-body">
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
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Identificação e quantitativo do público beneficiado</h3>
        </div>
        <div class="card-body">
          <div class="">
            <h4 class="mb-0">Total do público interno à UFCA</h4>
            <p>{{ $response->qtd_internal_audience ?? 'Não enviado' }}</p>
          </div>
          <div class="">
            <h4 class="mb-0">Total do público externo à UFCA</h4>
            <p>{{ $response->qtd_external_audience ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Avanços alcançados e impactos da ação extensionista</h3>
        </div>
        <div class="card-body">
          <div class="">
            <h4 class="mb-0">Descreva os avanços alcançados e impactos da ação extensionista</h4>
            <p>{{ $response->advances_extensionist_action ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Parcerias Internas</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
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
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Parcerias Externa</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">

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
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Ações vinculadas ao programa de extensão</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
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
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Desenvolvimento de tecnologia social</h3>
        </div>
        <div class="card-body">
          <div class="">
            <h4 class="mb-0">A ação atuou com o desenvolvimento de alguma tecnologia social? Se sim, descreva</h4>
            <p>{{ $response->social_technology_development ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Redes sociais criadas para o programa/projeto</h3>
        </div>
        <div class="card-body">
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
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Imagens das atividades realizadas</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">

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
          </div>
        </div>
      </div>

      <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-primary mb-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Disposições finais</h3>
        </div>
        <div class="card-body">
          <div class="">
            <h4 class="mb-0">Avaliação</h4>
            <p>{{ $response->instrument_avaliation ?? 'Não enviado' }}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-3">
      <div class="card">
        <div class="card-body">
          <h4 class="mb-1">Status atual</h4>
          <div class="badge fs-4 bg-{{ $info['color'] }} mb-3">
            {{ $info['name'] }}
          </div>
          @if ($response->was_finished == 0)
            <div class="alert">
              Espere essa resposta ser finalizada para comentar e avançar para as proximas etapas!
            </div>
          @else
            <form action="{{ route('response.update', $response->id) }}" method="post">
              @csrf
              <x-form-elements.select.select title="Proximo status" id="role" name="status">
                <x-slot:options>
                  <option value="" selected disabled>Selecione</option>
                  <option value="2" {{ $info['status'] == 2 ? 'selected' : '' }}>
                    Revisão</option>
                  <option value="4" {{ $info['status'] == 4 ? 'selected' : '' }}>
                    Aprovados
                  </option>
                </x-slot:options>
              </x-form-elements.select.select>
              <div id="comment" style="display: none;">
                @include('components.form-elements.textarea.textarea', [
                    'title' => 'Comentário',
                    'type' => 'text',
                    'id' => 'input_comment',
                    'class' => 'mb-3',
                    'name' => 'comment',
                    'placeholder' => 'Digite um comentário',
                    'value' => $comment->comment ?? ' ',
                ])
              </div>
              <hr class="mb-2 mt-2">
              <div class="d-flex">
                <button type="submit" class="btn btn-success ms-auto">Enviar</button>
              </div>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    document.getElementById('role').addEventListener('change', function() {
      var commentDiv = document.getElementById('comment');
      var roleValue = this.value;
      var textarea = document.getElementById('input_comment');

      if (roleValue == '2') {
        commentDiv.style.display = 'block';
        textarea.setAttribute('required', 'true');
      } else {
        commentDiv.style.display = 'none';
        textarea.removeAttribute('required');
      }
    });

    if (document.getElementById('role').value == '2') {
      document.getElementById('comment').style.display = 'block';
      document.getElementById('input_comment').setAttribute('required', 'true');
    }
  </script>
@endsection
