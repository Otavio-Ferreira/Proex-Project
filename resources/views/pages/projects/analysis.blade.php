@extends('templates.template')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/styleDataTable.css') }}">
  <style>
    #table thead th {
      white-space: nowrap;
      width: auto;
    }

    #table tbody td {
      white-space: nowrap;
    }

    #table {
      table-layout: fixed;
      width: 100%;
    }
  </style>
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="col">
            <div class="page-pretitle">
              <a href="{{ route('projects.import') }}">Importar</a> /
              <a href="">Análise</a>
            </div>
            <h2 class="page-title">
              Análise de trabalhos importados
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <a href="{{ route('projects.import') }}" class="btn btn-cyan">Voltar</a>
            <div>
              <x-table.search route="" action="GET" value="{{ request('search') }}" placeholder="Pesquisar..."
                button="true"></x-table.search>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="">
      @foreach ($projects as $project)
        @php
          $hasEmptyField = collect($project->getAttributes())->contains(function ($value, $key) {
              if (in_array($key, ['updated_at', 'deleted_at'])) {
                  return false;
              }

              return is_null($value) || $value === '';
          });
        @endphp
        <div class="alert {{ $hasEmptyField ? 'alert-danger' : '' }} d-flex justify-content-between align-items-center">
          <h4 class="text-truncate fw-normal m-0">{{ $project->title ?? 'Vazio' }}</h4>
          <div class="d-flex">
            <button class="btn btn-secondary me-2" data-bs-toggle="offcanvas"
              data-bs-target="#modal-edit-{{ $project->id }}">
              <i class="ti ti-edit"></i>
            </button>
            <button class="btn btn-azure me-2" data-bs-toggle="offcanvas"
              data-bs-target="#modal-details-{{ $project->id }}"><i class="ti ti-dots-vertical"></i></button>
            <button class="btn btn-danger" data-bs-toggle="modal"
              data-bs-target="#modal-delete-project{{ $project->id }}"><i class="ti ti-trash"></i></button>
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="d-flex justify-content-center mt-5">
    {{ $projects->links() }}
  </div>
  </div>

  @foreach ($projects as $project)
    <x-modal.offcanvas id="modal-details-{{ $project->id }}" class="offcanvas-end" title="Detalhes">
      <x-slot:content>
        <ul class="list-group list-group-flush">
          <li class="list-group-item {{ $project->title ?? 'text-danger' }}"><strong>Título:</strong>
            {{ $project->title ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->id_atividade ?? 'text-danger' }}"><strong>Id da atividade:</strong>
            {{ $project->id_atividade ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->id_projeto ?? 'text-danger' }}"><strong>Id do projeto:</strong>
            {{ $project->id_projeto ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->type ?? 'text-danger' }}"><strong>Tipo:</strong>
            {{ $project->type ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->modality ?? 'text-danger' }}"><strong>Modalidade:</strong>
            {{ $project->modality ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->thematic_area ?? 'text-danger' }}"><strong>Área temática:</strong>
            {{ $project->thematic_area ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->course_name->name ?? 'text-danger' }}"><strong>Curso:</strong>
            {{ $project->course_name->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->user->name ?? 'text-danger' }}"><strong>Coordenador:</strong>
            {{ $project->user->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->start_date ? '' : 'text-danger' }}"><strong>Início:</strong>
            {{ $project->start_date ? date('d/m/Y', strtotime($project->start_date)) : 'Vazio' }}</li>
          <li class="list-group-item {{ $project->end_date ? '' : 'text-danger' }}"><strong>Fim:</strong>
            {{ $project->end_date ? date('d/m/Y', strtotime($project->end_date)) : 'Vazio' }}</li>
          <li class="list-group-item {{ $project->year ? '' : 'text-danger' }}"><strong>Ano:</strong>
            {{ $project->year ? date('Y', strtotime($project->year)) : 'Vazio' }}</li>
          <li class="list-group-item"><strong>Status:</strong>
            {{ $project->status == 0 ? 'Inativo' : ($project->status == 1 ? 'Ativo' : 'Finalizado') }}</li>
        </ul>
      </x-slot:content>
    </x-modal.offcanvas>

    <x-modal.offcanvas id="modal-edit-{{ $project->id }}" class="offcanvas-end" title="Editar"
      route="{{ route('projects.update', $project->id) }}">
      <x-slot:content>
        <div class="col-12">
          @include('components.form-elements.input.input', [
              'title' => 'Título',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'title',
              'required' => 'true',
              'placeholder' => 'Digite o título',
              'value' => $project->title ?? '',
          ])

          @include('components.form-elements.input.input', [
              'title' => 'Id da atividade',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'id_atividade',
              'required' => 'true',
              'placeholder' => 'Digite o id da atividade',
              'value' => $project->id_atividade ?? '',
          ])

          @include('components.form-elements.input.input', [
              'title' => 'Id do projeto',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'id_projeto',
              'required' => 'true',
              'placeholder' => 'Digite o id do projeto',
              'value' => $project->id_projeto ?? '',
          ])

          <div class="mb-3">
            <label class="form-label required">Tipo</label>
            <select class="form-select" id="type" name="type" required>
              <option value="">
                Selecione
              </option>
              @foreach ($types as $type)
                <option value="{{ $type->value }}" {{ $project->type == $project->type ? 'selected' : '' }}>
                  {{ $type->value }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label required">Modalidade</label>
            <select class="form-select" id="modality" name="modality" required>
              <option value="">
                Selecione
              </option>
              @foreach ($modalities as $modality)
                <option value="{{ $modality->value }}" {{ $project->modality == $project->modality ? 'selected' : '' }}>
                  {{ $modality->value }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label required">Área temática</label>
            <select class="form-select" id="thematic_area" name="thematic_area" required>
              <option value="">
                Selecione
              </option>
              @foreach ($thematic_area as $area)
                <option value="{{ $area->value }}" {{ $project->thematic_area == $area->value ? 'selected' : '' }}>
                  {{ $area->value }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label required">Curso/Departamento</label>
            <select class="form-select" id="select-courses" name="course" required>
              <option value="">
                Selecione
              </option>
              @foreach ($courses as $base_course)
                <option value="{{ $base_course->id }}"
                  {{ $project->course ? ($project->course == $base_course->id ? 'selected' : '') : ' ' }}>
                  {{ $base_course->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="col-12">
          <div class="mb-3">
            <label class="form-label required">Coordenador</label>
            <select class="form-select" id="teachers" name="teacher">
              <option value="">
                Selecione
              </option>
              @foreach ($teachers as $teacher)
                <option value="{{ $teacher->id }}"
                  {{ $project->coordinator ? ($project->coordinator == $teacher->id ? 'selected' : '') : ' ' }}>
                  {{ $teacher->name }}</option>
              @endforeach
            </select>
          </div>

          @include('components.form-elements.input.input', [
              'title' => 'Data de início',
              'type' => 'date',
              'class' => 'mb-3',
              'name' => 'start_date',
              'required' => 'true',
              'value' => $project->start_date ?? '',
          ])

          @include('components.form-elements.input.input', [
              'title' => 'Data de término',
              'type' => 'date',
              'class' => 'mb-3',
              'name' => 'end_date',
              'required' => 'true',
              'value' => $project->end_date ?? '',
          ])

          @include('components.form-elements.input.input', [
              'title' => 'Ano do projeto',
              'type' => 'text',
              'class' => 'mb-3',
              'name' => 'year',
              'required' => 'true',
              'value' => $project->year ?? '',
          ])

          <div class="mb-3">
            <label class="form-label required">Status</label>
            <select class="form-select" id="status" name="status" required>
              <option value="0" {{ $project->status ? ($project->status == '0' ? 'selected' : '') : ' ' }}>
                Inativo</option>

              <option value="1" {{ $project->status ? ($project->status == '1' ? 'selected' : '') : ' ' }}>
                Ativo</option>

              <option value="2" {{ $project->status ? ($project->status == '2' ? 'selected' : '') : ' ' }}>
                Finalizado</option>
            </select>
          </div>
        </div>
      </x-slot:content>
    </x-modal.offcanvas>

    <x-modal.modal-alert route="{{ route('projects.destroy', $project->id) }}"
      id="modal-delete-project{{ $project->id }}" class="modal-dialog-centered modal-sm" background="bg-danger"
      classBody="text-center py-4" title="Excluír projeto" typeBtnClose="button" classBtnClose="me-auto w-100"
      textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-danger w-100" textBtnSave="Deletar">
      <x-slot:content>
        <i class="ti ti-alert-triangle icon icon-lg text-danger"></i>
        <h3>Tem certeza?</h3> 
        <div class="text-secondary">
          Você realmente deseja remover esse registro? Não será possível restaurá-lo depois!
        </div>
      </x-slot:content>
    </x-modal.modal-alert>
  @endforeach
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/kanban/dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/kanban/startDataTable.js') }}"></script>
  <script src="{{ asset('assets/js/kanban/kanbanColumn.js') }}"></script>
  <script>
    $(document).ready(function() {
      var table = $('#userTable').DataTable({
        info: false,
        ordering: false,
        paging: true,
        searching: true,
        autoWidth: false,
        scrollCollapse: false,
        border: false,
        lengthChange: false,
        pagingType: 'simple_numbers',
        language: {
          zeroRecords: " ",
          emptyTable: " ",
          paginate: {
            first: "Primeiro",
            last: "Último",
            next: "Próximo",
            previous: "Anterior"
          }
        }
      });

      $('#customFilter').on('keyup', function() {
        table.search(this.value).draw();
      });

      $('.customFilter').on('keyup', function() {
        table.search(this.value).draw();
      });
    });
  </script>
@endsection
