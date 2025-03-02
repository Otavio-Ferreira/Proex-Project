@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('forms.index') }}">Forms</a>
          </div>
          <h2 class="page-title">
            {{ $form ? "$form->title | Prazo: " . date('d/m/Y', strtotime($form->date)) : 'Formulário indisponível' }}
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    @if ($form)
      <div class="card col-2">
        <div class="card-body">
          <ul class="steps steps-counter steps-vertical">
            @foreach ($steps as $key => $step)
              <li
                class="step-item {{ $key <= session('step') ? 'cursor-pointer ' : '' }} {{ $key == session('step') ? ' active cursor-pointer' : '' }}"
                {!! $key <= session('step') ? 'onclick="show(' . $key . ')" ' : '' !!}>
                {{ $key }}ª Seção
              </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-10">
        @if (session()->has('step'))
          <p>Passo atual: {{ session('step') }}</p>
        @endif

        <div
          class="card p-0 border-top-0 border-end-0 border-bottom-0 border-4 border-primary card-form-step {{ !session()->has('step') || session('step') == 1 ? '' : 'd-none' }}"
          id="card-1">
          <div class="card-header">
            <h3 class="p-0 m-0">Título da ação de extensão</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('forms.persist') }}" method="post">
              @csrf
              <div class="mb-3">
                <label class="form-label">Título da ação</label>
                <select class="form-select" id="select-tags" name="title_action" required>
                  <option value="" selected>Selecione</option>
                  @foreach ($base_projects as $base_project)
                    <option value="{{ $base_project->id }}"
                      {{ isset($response->title_action) ? ($response->title_action == $base_project->id ? 'selected' : '') : '' }}>
                      {{ $base_project->title }}</option>
                  @endforeach
                </select>
              </div>

              <x-form-elements.select.select title="Tipo da ação" id="role" name="type_action">
                <x-slot:options>
                  <option value="" selected>Selecione</option>
                  <option value="Programa"
                    {{ isset($response->type_action) ? ($response->type_action == 'Programa' ? 'selected' : '') : '' }}>
                    Programa</option>
                  <option value="Projeto"
                    {{ isset($response->type_action) ? ($response->type_action == 'Projeto' ? 'selected' : '') : '' }}>
                    Projeto
                  </option>
                </x-slot:options>
              </x-form-elements.select.select>

              <x-form-elements.select.select title="Modalidade da ação" id="role" name="action_modality">
                <x-slot:options>
                  <option value="" selected>Selecione</option>

                  <option value="UFCA Itinerante"
                    {{ isset($response->action_modality) ? ($response->action_modality == 'UFCA Itinerante' ? 'selected' : '') : ' ' }}>
                    UFCA Itinerante</option>

                  <option value="Ampla Concorrência"
                    {{ isset($response->action_modality) ? ($response->action_modality == 'Ampla Concorrência' ? 'selected' : '') : ' ' }}>
                    Ampla Concorrência</option>

                  <option value="PROPE"
                    {{ isset($response->action_modality) ? ($response->action_modality == 'PROPE' ? 'selected' : '') : ' ' }}>
                    PROPE</option>
                </x-slot:options>
              </x-form-elements.select.select>
              <div class="d-flex">
                <button type="submit" class="btn btn-info ms-auto">Avançar</button>
              </div>
            </form>
          </div>
        </div>

        <div
          class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary p-0 card card-form-step {{ session()->has('step') && session('step') == 2 ? '' : 'd-none' }}"
          id="card-2">
          <div class="card-header">
            <h3 class="p-0 m-0">Dados do coordenador/tutor da ação de extensão</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('forms.persist') }}" method="post">
              @csrf
              @include('components.form-elements.input.input', [
                  'title' => 'Nome',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'coordinator_name',
                  'required' => 'true',
                  'placeholder' => 'Digite o seu nome',
                  'value' => isset($response->coordinator_name) ? $response->coordinator_name : '',
              ])

              <x-form-elements.select.select title="Perfil" id="" name="coordinator_profile">
                <x-slot:options>
                  <option value="" selected disabled>Selecione</option>
                  <option value="Docente"
                    {{ isset($response->coordinator_profile) ? ($response->coordinator_profile == 'Docente' ? 'selected' : '') : ' ' }}>
                    Docente</option>
                  <option value="Técnico Administrativo"
                    {{ isset($response->coordinator_profile) ? ($response->coordinator_profile == 'Técnico Administrativo' ? 'selected' : '') : ' ' }}>
                    Técnico Administrativo</option>
                  <option value="Discente"
                    {{ isset($response->coordinator_profile) ? ($response->coordinator_profile == 'Discente' ? 'selected' : '') : ' ' }}>
                    Discente</option>
                </x-slot:options>
              </x-form-elements.select.select>

              @include('components.form-elements.input.input', [
                  'title' => 'SIAPE',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'coordinator_siape',
                  'required' => 'true',
                  'placeholder' => 'Digite o seu siape',
                  'value' => isset($response->coordinator_siape) ? $response->coordinator_siape : '',
              ])

              <div class="mb-3">
                <label class="form-label">Curso</label>
                <select class="form-select" id="select-courses" name="coordinator_course" required>
                  <option value="" selected>Selecione</option>
                  @foreach ($base_courses as $base_course)
                    <option value="{{ $base_course->id }}"
                      {{ isset($response->coordinator_course) ? ($response->coordinator_course == $base_course->id ? 'selected' : '') : '' }}>
                      {{ $base_course->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="d-flex">
                <button type="submit" class="btn btn-info ms-auto">Avançar</button>
              </div>
            </form>
          </div>
        </div>

        <div
          class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 3 ? '' : 'd-none' }}"
          id="card-3">
          <div class="card-header">
            <h3 class="p-0 m-0">Detalhamento de atividades</h3>
          </div>
          <div class="card-body">
            <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
              data-bs-target="#modal-add-activity">
              <i class="icon ti ti-activity-plus"></i>
              Adicionar atividade
            </a>
            <x-modal.modal route="{{ route('activitys.store') }}" id="modal-add-activity" class="modal-dialog-centered"
              title="Adicionar atividade" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
              typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
              <x-slot:content>
                @include('components.form-elements.textarea.textarea', [
                    'title' => 'Atividade',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'activity',
                    'required' => 'true',
                ])
                @include('components.form-elements.input.input', [
                    'title' => 'Local',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'address',
                    'required' => 'true',
                    'placeholder' => 'Digite o local',
                ])
              </x-slot:content>
            </x-modal.modal>

            <div class="table-responsive">
              @if (!isset($response))
                <div class="alert alert-yellow mt-3">
                  Nenhuma atividade adicionada
                </div>
              @else
                <div class="card p-0 mt-3">
                  <x-table.table tableClass="table-vcenter card-table table-striped">
                    <x-slot:ths>
                      <th>Atividade</th>
                      <th>Local</th>
                      <th width="5%"></th>
                      <th width="5%"></th>
                    </x-slot:ths>
                    <x-slot:trs>
                      @foreach ($response->activitys as $activity)
                        <tr>
                          <td>{{ $activity->activity }}</td>
                          <td>{{ $activity->address }}</td>
                          <td>
                            <button class="btn btn-secondary" data-bs-toggle="modal"
                              data-bs-target="#modal-edit-activity{{ $activity->id }}"><i
                                class="ti ti-edit"></i></button>
                            <x-modal.modal route="{{ route('activitys.update', $activity->id) }}"
                              id="modal-edit-activity{{ $activity->id }}" class="modal-dialog-centered"
                              title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto"
                              textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                              textBtnSave="Salvar">
                              <x-slot:content>
                                @include('components.form-elements.textarea.textarea', [
                                    'title' => 'Atividade',
                                    'type' => 'text',
                                    'class' => 'mb-3',
                                    'name' => 'activity',
                                    'required' => 'true',
                                    'value' => $activity->activity,
                                ])
                                @include('components.form-elements.input.input', [
                                    'title' => 'Local',
                                    'type' => 'text',
                                    'class' => 'mb-3',
                                    'name' => 'address',
                                    'required' => 'true',
                                    'placeholder' => 'Digite o local',
                                    'value' => $activity->address,
                                ])
                              </x-slot:content>
                            </x-modal.modal>
                          </td>
                          <td>
                            <button class="btn btn-danger" data-bs-toggle="modal"
                              data-bs-target="#modal-delete-activity{{ $activity->id }}"><i
                                class="ti ti-trash"></i></button>

                            <x-modal.modal-alert route="{{ route('activitys.destroy', $activity->id) }}"
                              id="modal-delete-activity{{ $activity->id }}" class="modal-dialog-centered modal-sm"
                              background="bg-danger" classBody="text-center py-4" title="Excluír atividade"
                              typeBtnClose="button" classBtnClose="me-auto w-100" textBtnClose="Cancelar"
                              typeBtnSave="submit" classBtnSave="btn-danger w-100" textBtnSave="Deletar">
                              <x-slot:content>
                                <i class="ti ti-alert-triangle icon icon-lg text-danger"></i>
                                <h3>Tem certeza?</h3>
                                <div class="text-secondary">
                                  Você realmente deseja remover esse registro? Não será possível restaurá-lo depois!
                                </div>
                              </x-slot:content>
                            </x-modal.modal-alert>
                          </td>
                        </tr>
                      @endforeach
                    </x-slot:trs>
                  </x-table.table>
                </div>
              @endif
            </div>

            @if (isset($response))
              @if ($response->activitys->count() > 0)
                <div class="d-flex mt-3">
                  <a href="{{ route('forms.advance') }}" class="btn btn-info ms-auto">Avançar</a>
                </div>
              @endif
            @endif
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-4">
          <div class="card-header">
            <h3 class="p-0 m-0">Identificação e quantitativo do público beneficiado</h3>
          </div>
          <div class="card-body">
            @include('components.form-elements.input.input', [
                'title' => 'Total do público interno à UFCA',
                'type' => 'number',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
            @include('components.form-elements.input.input', [
                'title' => 'Total do público externo à UFCA',
                'type' => 'number',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-5">
          <div class="card-header">
            <h3 class="p-0 m-0">Avanços alcançados e impactos da ação extensionista</h3>
          </div>
          <div class="card-body">
            @include('components.form-elements.textarea.textarea', [
                'title' => 'Descreva os avanços alcançados e impactos da ação extensionista',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-6">
          <div class="card-header">
            <h3 class="p-0 m-0">Parcerias Internas</h3>
          </div>
          <div class="card-body">
            <h4>DESCRIÇÃO DAS PARCERIAS INTERNAS FIRMADAS DURANTE O PERÍODO DE REALIZAÇÃO DA AÇÃO</h4>

            <x-form-elements.select.select title=" Título da ação parceira" id="role" name="role">
              <x-slot:options>
                <option value="" selected>Selecione</option>
                @foreach ($base_project as $item)
                  <option value="">{{ $item }}</option>
                @endforeach
              </x-slot:options>
            </x-form-elements.select.select>
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-7">
          <div class="card-header">
            <h3 class="p-0 m-0">Parcerias externas</h3>
          </div>
          <div class="card-body">
            <h4>DESCRIÇÃO DAS PARCERIAS EXTERNAS FIRMADAS DURANTE O PERÍODO DE REALIZAÇÃO DA AÇÃO</h4>
            @include('components.form-elements.input.input', [
                'title' => 'Nome do Parceiro',
                'type' => 'number',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
            <x-form-elements.select.select title="Tipo de Instituição" id="role" name="role">
              <x-slot:options>
                <option value="" selected>Selecione</option>
                <option value="">Movimento Social Organizado (MSO)</option>
                <option value="">Privado (PR)</option>
                <option value="">Público Municipal (PM)</option>
                <option value="">Público Estadual (PE)</option>
                <option value="">Público Federal (PF)</option>
              </x-slot:options>
            </x-form-elements.select.select>
            <x-form-elements.select.select title="Tipo de Parceria*" id="role" name="role">
              <x-slot:options>
                <option value="" selected>Selecione</option>
                <option value="">Cooperação (CP)</option>
                <option value="">Convênio (CV)</option>
                <option value="">Contrato (CT)</option>
              </x-slot:options>
            </x-form-elements.select.select>
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-8">
          <div class="card-header">
            <h3 class="p-0 m-0">Ações vinculadas ao programa de extensão</h3>
          </div>
          <div class="card-body">
            @include('components.form-elements.textarea.textarea', [
                'title' => 'Liste os títulos das Ações que se articulam ao Programa de Extensão',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])

            <x-form-elements.select.select title="A Ação é voltada para escolas públicas? " id="role"
              name="role">
              <x-slot:options>
                <option value="" selected>Selecione</option>
                <option value="">Sim</option>
                <option value="">Não</option>
              </x-slot:options>
            </x-form-elements.select.select>
            @include('components.form-elements.textarea.textarea', [
                'title' => 'A Ação estabeleceu parceria internacional? Se sim, descreva',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-9">
          <div class="card-header">
            <h3 class="p-0 m-0">A ação atuou com o desenvolvimento de alguma tecnologia social</h3>
          </div>
          <div class="card-body">
            @include('components.form-elements.textarea.textarea', [
                'title' => 'A Ação atuou com o Desenvolvimento de alguma Tecnologia Social? Se sim, descreva',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-10">
          <div class="card-header">
            <h3 class="p-0 m-0">Redes sociais criadas para o programa/projeto</h3>
          </div>
          <div class="card-body">
            @include('components.form-elements.textarea.textarea', [
                'title' => 'Liste os dados das redes sociais criadas para o programa/projeto:',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
          </div>
        </div>

        <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 d-none card-form-step"
          id="card-11">
          <div class="card-header">
            <h3 class="p-0 m-0">Disposições finais</h3>
          </div>
          <div class="card-body">
            @include('components.form-elements.textarea.textarea', [
                'title' =>
                    'Como a equipe avalia este instrumento de monitoramento? Sugere a abordagem de alguma questão que não esteve aqui ou que seja abordado de outra forma? Tem mais alguma crítica e/ou sugestões que deseja fazer à equipe da PROEX?',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
            @include('components.form-elements.textarea.textarea', [
                'title' =>
                    'Com relação às imagens submetidas na pergunta anterior, informe aqui as legendas de cada um informando local, data e descrição da atividade. Por exemplo: "Foto 1 - Participação no evento X no Colégio Y do município Z. 20/10/2023".',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'email',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
            ])
          </div>
        </div>
      </div>
    @else
      <div class="alert alert-info">Nenhum formulário disponível!</div>
    @endif
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
  <script>
    function show(id) {
      let divs = document.getElementsByClassName('card-form-step');

      for (let el of divs) {
        el.classList.add('d-none');
      }
      let div = document.getElementById(`card-${id}`);
      if (div) {
        div.classList.remove('d-none');
      }
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var el = document.getElementById('select-tags');
      if (el) {
        new TomSelect(el, {
          copyClassesToDropdown: false,
          dropdownParent: 'body',
          controlInput: '<input>',
          render: {
            item: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            },
            option: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            }
          }
        });
      }
    });
    document.addEventListener("DOMContentLoaded", function() {
      var el2 = document.getElementById('select-courses');
      if (el2) {
        new TomSelect(el2, {
          copyClassesToDropdown: false,
          dropdownParent: 'body',
          controlInput: '<input>',
          render: {
            item: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            },
            option: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            }
          }
        });
      }
    });
  </script>
@endsection
