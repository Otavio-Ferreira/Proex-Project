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
          @if ($finished)
            @if ($response)
              @if (!$response->was_finished)
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-finish-response"><i
                    class="icon ti ti-check"></i>Finalizar Formulário</button>

                <x-modal.modal-alert route="{{ route('forms.finish') }}" id="modal-finish-response"
                  class="modal-dialog-centered modal-sm" background="bg-success" classBody="text-center py-4"
                  title="Finalizar formulário" typeBtnClose="button" classBtnClose="me-auto w-100" textBtnClose="Cancelar"
                  typeBtnSave="submit" classBtnSave="btn-success w-100" textBtnSave="Finalizar">
                  <x-slot:content>
                    <i class="ti ti-alert-triangle icon icon-lg text-success"></i>
                    <h3>Tem certeza?</h3>
                    <div class="text-secondary">
                      Você realmente deseja finalizar o formulário? Não será possível modificá-lo depois!
                    </div>
                  </x-slot:content>
                </x-modal.modal-alert>
              @endif
            @endif
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    @if ($form)
      @if (isset($response) && $response->was_finished)
        <div class="alert alert-success">Sua resposta ja foi enviada!</div>
      @else
        <div class="card col-12 col-md-12 col-lg-2 d-none d-lg-block">
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
        <div class="col-12 col-md-10">
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
                    <option value="" selected disabled>Selecione</option>
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
                    <option value="" selected disabled>Selecione</option>

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
                    'placeholder' => 'Digite o nome do coordenador/tutor',
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
                    <option value="" selected disabled>Selecione</option>
                    @foreach ($base_courses as $base_course)
                      <option value="{{ $base_course->id }}"
                        {{ isset($response->coordinator_course) ? ($response->coordinator_course == $base_course->id ? 'selected' : '') : '' }}>
                        {{ $base_course->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="d-flex w-100 justify-content-between mt-3">
                  <a href="{{ route('forms.return', 2) }}" type="submit" class="btn btn-outline-info">
                    <i class="icon ti ti-chevron-left"></i>
                    Voltar</a>
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
              <x-modal.modal route="{{ route('activitys.store') }}" id="modal-add-activity"
                class="modal-dialog-centered" title="Adicionar atividade" typeBtnClose="button"
                classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.textarea.textarea', [
                      'title' => 'Atividade',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'activity',
                      'required' => 'true',
                      'placeholder' => 'Digite uma atividade',
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
                  <div class="d-flex w-100 justify-content-between mt-3">
                    <a href="{{ route('forms.return', 3) }}" type="submit" class="btn btn-outline-info">
                      <i class="icon ti ti-chevron-left"></i>
                      Voltar</a>
                    <a href="{{ route('forms.advance', 3) }}" class="btn btn-info ms-auto">Avançar</a>
                  </div>
                @endif
              @endif
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0  card-form-step {{ session()->has('step') && session('step') == 4 ? '' : 'd-none' }}"
            id="card-4">
            <div class="card-header">
              <h3 class="p-0 m-0">Identificação e quantitativo do público beneficiado</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('forms.persist') }}" method="post">
                @csrf
                @include('components.form-elements.input.input', [
                    'title' => 'Total do público interno à UFCA',
                    'type' => 'number',
                    'class' => 'mb-3',
                    'name' => 'qtd_internal_audience',
                    'required' => 'true',
                    'placeholder' => 'Digite o seu nome',
                    'value' => isset($response->qtd_internal_audience) ? $response->qtd_internal_audience : '',
                ])
                @include('components.form-elements.input.input', [
                    'title' => 'Total do público externo à UFCA',
                    'type' => 'number',
                    'class' => 'mb-3',
                    'name' => 'qtd_external_audience',
                    'required' => 'true',
                    'placeholder' => 'Digite o seu nome',
                    'value' => isset($response->qtd_external_audience) ? $response->qtd_external_audience : '',
                ])

                <div class="d-flex w-100 justify-content-between mt-3">
                  <a href="{{ route('forms.return', 4) }}" type="submit" class="btn btn-outline-info">
                    <i class="icon ti ti-chevron-left"></i>
                    Voltar</a>
                  <button type="submit" class="btn btn-info ms-auto">Avançar</button>
                </div>
              </form>
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 5 ? '' : 'd-none' }}"
            id="card-5">
            <div class="card-header">
              <h3 class="p-0 m-0">Avanços alcançados e impactos da ação extensionista</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('forms.persist') }}" method="post">
                @csrf
                @include('components.form-elements.textarea.textarea', [
                    'title' => 'Descreva os avanços alcançados e impactos da ação extensionista',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'advances_extensionist_action',
                    'required' => 'true',
                    'value' => isset($response->advances_extensionist_action)
                        ? $response->advances_extensionist_action
                        : '',
                ])

                <div class="d-flex w-100 justify-content-between mt-3">
                  <a href="{{ route('forms.return', 5) }}" type="submit" class="btn btn-outline-info">
                    <i class="icon ti ti-chevron-left"></i>
                    Voltar</a>
                  <button type="submit" class="btn btn-info ms-auto">Avançar</button>
                </div>
              </form>
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 6 ? '' : 'd-none' }}"
            id="card-6">
            <div class="card-header">
              <h3 class="p-0 m-0">Parcerias Internas</h3>
            </div>
            <div class="card-body">

              <form action="{{ route('internalPartners.store') }}" method="post">
                @csrf
                <div class="mb-3">
                  <label class="form-label">Título da ação parceira</label>
                  <div class="d-flex gap-2">
                    <select class="form-select" id="select-tags-partner" name="title_partner" required>
                      <option value="" selected>Selecione</option>
                      @foreach ($base_projects as $base_project)
                        <option value="{{ $base_project->id }}">
                          {{ $base_project->title }}</option>
                      @endforeach
                    </select>
                    <button type="submit" class="btn btn-success ms-auto">Adicionar</button>
                  </div>
                </div>
              </form>

              <div class="table-responsive">
                @if (!isset($response))
                  <div class="alert alert-yellow mt-3">
                    Nenhuma atividade adicionada
                  </div>
                @else
                  <div class="card p-0 mt-3">
                    <x-table.table tableClass="table-vcenter card-table table-striped">
                      <x-slot:ths>
                        <th>Título da ação parceira</th>
                        {{-- <th width="5%"></th> --}}
                        <th width="5%"></th>
                      </x-slot:ths>
                      <x-slot:trs>
                        @foreach ($response->internal_partners as $internal_partner)
                          <tr>
                            <td>{{ $internal_partner->title_action_partner->title }}</td>
                            {{-- <td>
                          <button class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modal-edit-internal_partner{{ $internal_partner->id }}"><i
                              class="ti ti-edit"></i></button>
                          <x-modal.modal route="{{ route('internalPartners.update', $internal_partner->id) }}"
                            id="modal-edit-internal_partner{{ $internal_partner->id }}" class="modal-dialog-centered"
                            title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto"
                            textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                            textBtnSave="Salvar">
                            <x-slot:content>
                              @include('components.form-elements.textarea.textarea', [
                                  'title' => 'Atividade',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'internal_partner',
                                  'required' => 'true',
                                  'value' => $internal_partner->internal_partner,
                              ])
                              @include('components.form-elements.input.input', [
                                  'title' => 'Local',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'address',
                                  'required' => 'true',
                                  'placeholder' => 'Digite o local',
                                  'value' => $internal_partner->address,
                              ])
                            </x-slot:content>
                          </x-modal.modal>
                        </td> --}}
                            <td>
                              <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-delete-internal_partner{{ $internal_partner->id }}"><i
                                  class="ti ti-trash"></i></button>

                              <x-modal.modal-alert
                                route="{{ route('internalPartners.destroy', $internal_partner->id) }}"
                                id="modal-delete-internal_partner{{ $internal_partner->id }}"
                                class="modal-dialog-centered modal-sm" background="bg-danger"
                                classBody="text-center py-4" title="Excluír atividade" typeBtnClose="button"
                                classBtnClose="me-auto w-100" textBtnClose="Cancelar" typeBtnSave="submit"
                                classBtnSave="btn-danger w-100" textBtnSave="Deletar">
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

                @if (isset($response))
                  @if ($response->internal_partners->count() > 0)
                    <div class="d-flex w-100 justify-content-between mt-3">
                      <a href="{{ route('forms.return', 6) }}" type="submit" class="btn btn-outline-info">
                        <i class="icon ti ti-chevron-left"></i>
                        Voltar</a>
                      <a href="{{ route('forms.advance', 6) }}" class="btn btn-info ms-auto">Avançar</a>
                    </div>
                  @endif
                @endif
              </div>
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 7 ? '' : 'd-none' }}"
            id="card-7">
            <div class="card-header">
              <h3 class="p-0 m-0">Parcerias externas</h3>
            </div>
            <div class="card-body">

              <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-add-externalPartner">
                <i class="icon ti ti-externalPartner-plus"></i>
                Adicionar parceiro
              </a>
              <x-modal.modal route="{{ route('externalPartners.store') }}" id="modal-add-externalPartner"
                class="modal-dialog-centered" title="Adicionar parceiro externo" typeBtnClose="button"
                classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.input.input', [
                      'title' => 'Nome do Parceiro',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'name_partner',
                      'required' => 'true',
                      'placeholder' => 'Digite o nome do parceiro',
                  ])
                  <x-form-elements.select.select title="Tipo de Instituição" id="institution_type"
                    name="institution_type">
                    <x-slot:options>
                      <option value="" selected disabled>Selecione</option>
                      <option value="Movimento Social Organizado (MSO)">Movimento Social Organizado (MSO)</option>
                      <option value="Privado (PR)">Privado (PR)</option>
                      <option value="Público Municipal (PM)">Público Municipal (PM)</option>
                      <option value="Público Estadual (PE)">Público Estadual (PE)</option>
                      <option value="Público Federal (PF)">Público Federal (PF)</option>
                    </x-slot:options>
                  </x-form-elements.select.select>
                  <x-form-elements.select.select title="Tipo de Parceria" id="partnership_type"
                    name="partnership_type">
                    <x-slot:options>
                      <option value="" selected disabled>Selecione</option>
                      <option value="Cooperação (CP)">Cooperação (CP)</option>
                      <option value="Convênio (CV)">Convênio (CV)</option>
                      <option value="Contrato (CT)">Contrato (CT)</option>
                    </x-slot:options>
                  </x-form-elements.select.select>
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
                        <th>Nome do parceiro</th>
                        <th>Tipo de instituição</th>
                        <th>Tipo de parceria</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </x-slot:ths>
                      <x-slot:trs>
                        @foreach ($response->external_partners as $externalPartner)
                          <tr>
                            <td>{{ $externalPartner->name_partner }}</td>
                            <td>{{ $externalPartner->institution_type }}</td>
                            <td>{{ $externalPartner->partnership_type }}</td>
                            <td>
                              <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-externalPartner{{ $externalPartner->id }}"><i
                                  class="ti ti-edit"></i></button>
                              <x-modal.modal route="{{ route('externalPartners.update', $externalPartner->id) }}"
                                id="modal-edit-externalPartner{{ $externalPartner->id }}" class="modal-dialog-centered"
                                title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto"
                                textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                                textBtnSave="Salvar">
                                <x-slot:content>
                                  @include('components.form-elements.input.input', [
                                      'title' => 'Nome do Parceiro',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'name_partner',
                                      'required' => 'true',
                                      'placeholder' => 'Digite o nome do parceiro',
                                      'value' => $externalPartner->name_partner,
                                  ])
                                  <x-form-elements.select.select title="Tipo de Instituição" id=""
                                    name="institution_type">
                                    <x-slot:options>
                                      <option value="" selected>Selecione</option>
                                      <option value="Movimento Social Organizado (MSO)"
                                        {{ $externalPartner->institution_type == 'Movimento Social Organizado (MSO)' ? 'selected' : '' }}>
                                        Movimento Social Organizado (MSO)</option>
                                      <option value="Privado (PR)"
                                        {{ $externalPartner->institution_type == 'Privado (PR)' ? 'selected' : '' }}>
                                        Privado (PR)</option>
                                      <option value="Público Municipal (PM)"
                                        {{ $externalPartner->institution_type == 'Público Municipal (PM)' ? 'selected' : '' }}>
                                        Público Municipal (PM)</option>
                                      <option value="Público Estadual (PE)"
                                        {{ $externalPartner->institution_type == 'Público Estadual (PE' ? 'selected' : '' }}>
                                        Público Estadual (PE)</option>
                                      <option value="Público Federal (PF)"
                                        {{ $externalPartner->institution_type == 'Público Federal (PF)' ? 'selected' : '' }}>
                                        Público Federal (PF)</option>
                                    </x-slot:options>
                                  </x-form-elements.select.select>
                                  <x-form-elements.select.select title="Tipo de Parceria" id="role"
                                    name="partnership_type">
                                    <x-slot:options>
                                      <option value="" selected>Selecione</option>
                                      <option value="Cooperação (CP)"
                                        {{ $externalPartner->partnership_type == 'Cooperação (CP)' ? 'selected' : '' }}>
                                        Cooperação (CP)</option>
                                      <option value="Convênio (CV)"
                                        {{ $externalPartner->partnership_type == 'Convênio (CV)' ? 'selected' : '' }}>
                                        Convênio (CV)</option>
                                      <option value="Contrato (CT)"
                                        {{ $externalPartner->partnership_type == 'Contrato (CT)' ? 'selected' : '' }}>
                                        Contrato (CT)</option>
                                    </x-slot:options>
                                  </x-form-elements.select.select>
                                </x-slot:content>
                              </x-modal.modal>
                            </td>
                            <td>
                              <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-delete-externalPartner{{ $externalPartner->id }}"><i
                                  class="ti ti-trash"></i></button>

                              <x-modal.modal-alert route="{{ route('externalPartners.destroy', $externalPartner->id) }}"
                                id="modal-delete-externalPartner{{ $externalPartner->id }}"
                                class="modal-dialog-centered modal-sm" background="bg-danger"
                                classBody="text-center py-4" title="Excluír atividade" typeBtnClose="button"
                                classBtnClose="me-auto w-100" textBtnClose="Cancelar" typeBtnSave="submit"
                                classBtnSave="btn-danger w-100" textBtnSave="Deletar">
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
                @if ($response->external_partners->count() > 0)
                  <div class="d-flex w-100 justify-content-between mt-3">
                    <a href="{{ route('forms.return', 7) }}" type="submit" class="btn btn-outline-info">
                      <i class="icon ti ti-chevron-left"></i>
                      Voltar</a>
                    <a href="{{ route('forms.advance', 7) }}" class="btn btn-info ms-auto">Avançar</a>
                  </div>
                @endif
              @endif
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 8 ? '' : 'd-none' }}"
            id="card-8">
            <div class="card-header">
              <h3 class="p-0 m-0">Ações vinculadas ao programa de extensão</h3>
            </div>
            <div class="card-body">
              <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-add-extensionActions">
                <i class="icon ti ti-extensionActions-plus"></i>
                Adicionar ação
              </a>
              <x-modal.modal route="{{ route('extencionActions.store') }}" id="modal-add-extensionActions"
                class="modal-dialog-centered" title="Adicionar ação" typeBtnClose="button" classBtnClose="me-auto"
                textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.input.input', [
                      'title' => 'Ação que se articula ao programa de extensão',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'title_action',
                      'required' => 'true',
                      'placeholder' => 'Digite a ação',
                  ])

                  <x-form-elements.select.select title="A ação é voltada para escolas públicas? " id="role"
                    name="its_for_public_schools">
                    <x-slot:options>
                      <option value="" selected disabled>Selecione</option>
                      <option value="1">Sim</option>
                      <option value="0">Não</option>
                    </x-slot:options>
                  </x-form-elements.select.select>
                  @include('components.form-elements.textarea.textarea', [
                      'title' => 'A ação estabeleceu parceria internacional? Se sim, descreva',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'international_description',
                      'required' => 'false',
                      'placeholder' => 'Descrição',
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
                        <th>Ação</th>
                        <th>Escolas públicas?</th>
                        <th>Descrição internacional</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </x-slot:ths>
                      <x-slot:trs>
                        @foreach ($response->extension_actions as $extensionActions)
                          <tr>
                            <td>{{ $extensionActions->title_action }}</td>
                            <td>{{ $extensionActions->its_for_public_schools == 1 ? 'Sim' : 'Não' }}</td>
                            <td>{{ $extensionActions->international_description }}</td>
                            <td>
                              <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-extensionActions{{ $extensionActions->id }}"><i
                                  class="ti ti-edit"></i></button>
                              <x-modal.modal route="{{ route('extencionActions.update', $extensionActions->id) }}"
                                id="modal-edit-extensionActions{{ $extensionActions->id }}"
                                class="modal-dialog-centered" title="Editar atividade" typeBtnClose="button"
                                classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit"
                                classBtnSave="btn-primary" textBtnSave="Salvar">
                                <x-slot:content>
                                  @include('components.form-elements.input.input', [
                                      'title' =>
                                          'Liste os títulos das Ações que se articulam ao Programa de Extensão',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'title_action',
                                      'required' => 'true',
                                      'value' => $extensionActions->title_action,
                                  ])

                                  <x-form-elements.select.select title="A Ação é voltada para escolas públicas? "
                                    id="" name="its_for_public_schools">
                                    <x-slot:options>
                                      <option value="1"
                                        {{ $extensionActions->its_for_public_schools == 1 ? 'selected' : '' }}>Sim
                                      </option>

                                      <option value="0"
                                        {{ $extensionActions->its_for_public_schools == 0 ? 'selected' : '' }}>Não
                                      </option>
                                    </x-slot:options>
                                  </x-form-elements.select.select>
                                  @include('components.form-elements.textarea.textarea', [
                                      'title' => 'A Ação estabeleceu parceria internacional? Se sim, descreva',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'international_description',
                                      'required' => 'false',
                                      'value' => $extensionActions->international_description,
                                  ])
                                </x-slot:content>
                              </x-modal.modal>
                            </td>
                            <td>
                              <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-delete-extensionActions{{ $extensionActions->id }}"><i
                                  class="ti ti-trash"></i></button>

                              <x-modal.modal-alert
                                route="{{ route('extencionActions.destroy', $extensionActions->id) }}"
                                id="modal-delete-extensionActions{{ $extensionActions->id }}"
                                class="modal-dialog-centered modal-sm" background="bg-danger"
                                classBody="text-center py-4" title="Excluír atividade" typeBtnClose="button"
                                classBtnClose="me-auto w-100" textBtnClose="Cancelar" typeBtnSave="submit"
                                classBtnSave="btn-danger w-100" textBtnSave="Deletar">
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
                @if ($response->extension_actions->count() > 0)
                  <div class="d-flex w-100 justify-content-between mt-3">
                    <a href="{{ route('forms.return', 8) }}" type="submit" class="btn btn-outline-info">
                      <i class="icon ti ti-chevron-left"></i>
                      Voltar</a>
                    <a href="{{ route('forms.advance', 8) }}" class="btn btn-info ms-auto">Avançar</a>
                  </div>
                @endif
              @endif
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 9 ? '' : 'd-none' }}"
            id="card-9">
            <div class="card-header">
              <h3 class="p-0 m-0">Desenvolvimento de tecnologia social</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('forms.persist') }}" method="post">
                @csrf
                @include('components.form-elements.textarea.textarea', [
                    'title' => 'A ação atuou com o desenvolvimento de alguma tecnologia social? Se sim, descreva',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'social_technology_development',
                    'required' => 'true',
                    'value' => isset($response->social_technology_development)
                        ? $response->social_technology_development
                        : '',
                ])

                <div class="d-flex w-100 justify-content-between mt-3">
                  <a href="{{ route('forms.return', 9) }}" type="submit" class="btn btn-outline-info">
                    <i class="icon ti ti-chevron-left"></i>
                    Voltar</a>
                  <button type="submit" class="btn btn-info ms-auto">Avançar</button>
                </div>
              </form>
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 10 ? '' : 'd-none' }}"
            id="card-10">
            <div class="card-header">
              <h3 class="p-0 m-0">Redes sociais criadas para o programa/projeto</h3>
            </div>
            <div class="card-body">
              <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-add-socialMedia">
                Adicionar rede social
              </a>
              <x-modal.modal route="{{ route('socialMedia.store') }}" id="modal-add-socialMedia"
                class="modal-dialog-centered" title="Adicionar rede social" typeBtnClose="button"
                classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.input.input', [
                      'title' => 'Nome da rede social',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'name',
                      'required' => 'true',
                      'placeholder' => 'Digite o nome da rede social',
                  ])
                  @include('components.form-elements.input.input', [
                      'title' => 'Link da rede social',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'link',
                      'required' => 'true',
                      'placeholder' => 'Digite o link da rede social',
                  ])
                </x-slot:content>
              </x-modal.modal>

              <div class="table-responsive">
                @if (!isset($response))
                  <div class="alert alert-yellow mt-3">
                    Nenhuma rede social adicionada
                  </div>
                @else
                  <div class="card p-0 mt-3">
                    <x-table.table tableClass="table-vcenter card-table table-striped">
                      <x-slot:ths>
                        <th>Nome</th>
                        <th>Link</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </x-slot:ths>
                      <x-slot:trs>
                        @foreach ($response->social_medias as $socialMedia)
                          <tr>
                            <td>{{ $socialMedia->name }}</td>
                            <td>{{ $socialMedia->link }}</td>
                            <td>
                              <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-socialMedia{{ $socialMedia->id }}"><i
                                  class="ti ti-edit"></i></button>
                              <x-modal.modal route="{{ route('socialMedia.update', $socialMedia->id) }}"
                                id="modal-edit-socialMedia{{ $socialMedia->id }}" class="modal-dialog-centered"
                                title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto"
                                textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                                textBtnSave="Salvar">
                                <x-slot:content>
                                  @include('components.form-elements.input.input', [
                                      'title' => 'Nome da rede social',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'name',
                                      'required' => 'true',
                                      'value' => $socialMedia->name,
                                      'placeholder' => 'Digite o nome da rede social',
                                  ])
                                  @include('components.form-elements.input.input', [
                                      'title' => 'Link da rede social',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'link',
                                      'required' => 'true',
                                      'placeholder' => 'Digite o local',
                                      'value' => $socialMedia->link,
                                      'placeholder' => 'Digite o link da rede social',
                                  ])
                                </x-slot:content>
                              </x-modal.modal>
                            </td>
                            <td>
                              <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-delete-socialMedia{{ $socialMedia->id }}"><i
                                  class="ti ti-trash"></i></button>

                              <x-modal.modal-alert route="{{ route('socialMedia.destroy', $socialMedia->id) }}"
                                id="modal-delete-socialMedia{{ $socialMedia->id }}"
                                class="modal-dialog-centered modal-sm" background="bg-danger"
                                classBody="text-center py-4" title="Excluír atividade" typeBtnClose="button"
                                classBtnClose="me-auto w-100" textBtnClose="Cancelar" typeBtnSave="submit"
                                classBtnSave="btn-danger w-100" textBtnSave="Deletar">
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
                @if ($response->social_medias->count() > 0)
                  <div class="d-flex w-100 justify-content-between mt-3">
                    <a href="{{ route('forms.return', 10) }}" type="submit" class="btn btn-outline-info">
                      <i class="icon ti ti-chevron-left"></i>
                      Voltar</a>
                    <a href="{{ route('forms.advance', 10) }}" class="btn btn-info ms-auto">Avançar</a>
                  </div>
                @endif
              @endif

            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 11 ? '' : 'd-none' }}"
            id="card-11">
            <div class="card-header">
              <h3 class="p-0 m-0">Imagens das atividades realizadas (minímo 3)</h3>
            </div>
            <div class="card-body">
              <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
                data-bs-target="#modal-add-image">
                <i class="icon ti ti-image-plus"></i>
                Adicionar imagem
              </a>
              <x-modal.modal route="{{ route('images.store') }}" id="modal-add-image" class="modal-dialog-centered"
                title="Adicionar imagem" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
                typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.input.input', [
                      'title' => 'Imagem',
                      'type' => 'file',
                      'class' => 'mb-3',
                      'name' => 'image',
                      'required' => 'true',
                      'accept' => 'jpeg, .jpg, .png',
                  ])
                  @include('components.form-elements.input.input', [
                      'title' => 'Local',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'address',
                      'required' => 'true',
                      'placeholder' => 'Digite o local da atividade',
                  ])
                  @include('components.form-elements.input.input', [
                      'title' => 'Data',
                      'type' => 'date',
                      'class' => 'mb-3',
                      'name' => 'date',
                      'placeholder' => 'Digite a data da atividade',
                      'required' => 'true',
                  ])
                  @include('components.form-elements.textarea.textarea', [
                      'title' => 'Descrição',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'description',
                      'required' => 'true',
                      'placeholder' => 'Digite a descrição da atividade',
                  ])
                </x-slot:content>
              </x-modal.modal>

              <div class="table-responsive">
                @if (!isset($response))
                  <div class="alert alert-yellow mt-3">
                    Nenhuma imagem adicionada
                  </div>
                @else
                  <div class="card p-0 mt-3">
                    <x-table.table tableClass="table-vcenter card-table table-striped">
                      <x-slot:ths>
                        <th>Imagem</th>
                        <th>Local</th>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th width="5%"></th>
                        <th width="5%"></th>
                      </x-slot:ths>
                      <x-slot:trs>
                        @foreach ($response->images as $image)
                          <tr>
                            <td><a href="{{ asset($image->image) }}" target="_blank">Visualizar</a></td>
                            <td>{{ $image->address }}</td>
                            <td>{{ $image->date }}</td>
                            <td>{{ $image->description }}</td>
                            <td>
                              <button class="btn btn-secondary" data-bs-toggle="modal"
                                data-bs-target="#modal-edit-image{{ $image->id }}"><i
                                  class="ti ti-edit"></i></button>
                              <x-modal.modal route="{{ route('images.update', $image->id) }}"
                                id="modal-edit-image{{ $image->id }}" class="modal-dialog-centered"
                                title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto"
                                textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary"
                                textBtnSave="Salvar">
                                <x-slot:content>
                                  @include('components.form-elements.input.input', [
                                      'title' => 'Imagem',
                                      'type' => 'file',
                                      'class' => 'mb-3',
                                      'name' => 'image',
                                      'required' => 'false',
                                      'placeholder' => 'Digite uma imagem',
                                      'accept' => 'jpeg, .jpg, .png',
                                  ])
                                  @include('components.form-elements.input.input', [
                                      'title' => 'Local',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'address',
                                      'required' => 'true',
                                      'placeholder' => 'Digite o local da atividade',
                                      'value' => $image->address,
                                  ])
                                  @include('components.form-elements.input.input', [
                                      'title' => 'Data',
                                      'type' => 'date',
                                      'class' => 'mb-3',
                                      'name' => 'date',
                                      'placeholder' => 'Digite a data da atividade',
                                      'required' => 'true',
                                      'value' => $image->date,
                                  ])
                                  @include('components.form-elements.textarea.textarea', [
                                      'title' => 'Descrição',
                                      'type' => 'text',
                                      'class' => 'mb-3',
                                      'name' => 'description',
                                      'required' => 'true',
                                      'placeholder' => 'Digite a descrição da atividade',
                                      'value' => $image->description,
                                  ])
                                </x-slot:content>
                              </x-modal.modal>
                            </td>
                            <td>
                              <button class="btn btn-danger" data-bs-toggle="modal"
                                data-bs-target="#modal-delete-image{{ $image->id }}"><i
                                  class="ti ti-trash"></i></button>

                              <x-modal.modal-alert route="{{ route('images.destroy', $image->id) }}"
                                id="modal-delete-image{{ $image->id }}" class="modal-dialog-centered modal-sm"
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
                @if ($response->images->count() >= 3)
                  <div class="d-flex w-100 justify-content-between mt-3">
                    <a href="{{ route('forms.return', 11) }}" type="submit" class="btn btn-outline-info">
                      <i class="icon ti ti-chevron-left"></i>
                      Voltar</a>
                    <a href="{{ route('forms.advance', 11) }}" class="btn btn-info">Avançar</a>
                  </div>
                @endif
              @endif
            </div>
          </div>

          <div
            class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step {{ session()->has('step') && session('step') == 12 ? '' : 'd-none' }}"
            id="card-12">
            <div class="card-header">
              <h3 class="p-0 m-0">Disposições finais</h3>
            </div>
            <div class="card-body">
              <form action="{{ route('forms.persist') }}" method="post">
                @csrf
                @include('components.form-elements.textarea.textarea', [
                    'title' =>
                        'Como a equipe avalia este instrumento de monitoramento? Sugere a abordagem de alguma questão que não esteve aqui ou que seja abordado de outra forma? Tem mais alguma crítica e/ou sugestões que deseja fazer à equipe da PROEX?',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'instrument_avaliation',
                    'required' => 'true',
                    'placeholder' => '',
                    'value' => isset($response->instrument_avaliation) ? $response->instrument_avaliation : '',
                ])

                <div class="d-flex w-100 justify-content-between">
                  <a href="{{ route('forms.return', 12) }}" type="submit" class="btn btn-outline-info">
                    <i class="icon ti ti-chevron-left"></i>
                    Voltar</a>
                  <button type="submit" class="btn btn-info">Salvar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      @endif
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
    document.addEventListener("DOMContentLoaded", function() {
      var el2 = document.getElementById('select-tags-partner');
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
