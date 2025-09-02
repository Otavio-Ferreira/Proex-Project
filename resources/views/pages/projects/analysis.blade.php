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
            <div class="d-flex align-items-center">
              <a href="{{ route('projects.import') }}" class="btn btn-cyan">Voltar</a>
              {{-- <div class="input-icon me-2">
                <input type="text" value="" id="customFilter" class="form-control" placeholder="Pesquisar ...">
                <span class="input-icon-addon">
                  <i class="ti icon text-primary ti-search"></i>
                </span>
              </div> --}}
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
            <button class="btn btn-azure" data-bs-toggle="offcanvas"
              data-bs-target="#modal-details-{{ $project->id }}"><i class="ti ti-dots-vertical"></i></button>
          </div>
        </div>
      @endforeach

      {{-- <div class="table-responsive">
        <table class="border unded-3 w-100 table table-vcenter exclude bg-white  card-table table-striped" id="userTable">
          <thead>
            <tr>
              <th>Título</th>
              <th>Orientador</th>
              <th>Início</th>
              <th>Fim</th>
              <th>Status</th>
              <th width="5%"></th>
              <th width="5%"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($projects as $project)
              <tr>
                <td>{{ $project->title }}</td>
                <td>{{ $project->user->name ?? ''}}</td>
                <td>{{ date('d/m/Y', strtotime($project->start_date)) }}</td>
                <td>{{ date('d/m/Y', strtotime($project->end_date)) }}</td>
                <td>
                  <x-badge.badge
                    class="{{ $project->status == 0 ? 'bg-danger' : ($project->status == 1 ? 'bg-success' : 'bg-primary') }}">
                    <x-slot:content>
                      {{ $project->status == 0 ? 'Inativo' : ($project->status == 1 ? 'Ativo' : 'Finalizado') }}
                    </x-slot:content>
                  </x-badge.badge>
                </td>
                <td>
                  <a href="{{route('projects.edit', $project->id)}}" class="btn btn-secondary"><i
                      class="ti ti-edit"></i></a>
                </td>
                <td>
                  <button class="btn btn-azure" data-bs-toggle="offcanvas"
                    data-bs-target="#modal-details-{{ $project->id }}"><i class="ti ti-dots-vertical"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div> --}}
    </div>
  </div>
  @foreach ($projects as $project)
    <x-modal.offcanvas id="modal-details-{{ $project->id }}" class="offcanvas-end" title="Detalhes">
      <x-slot:content>
        <ul class="list-group list-group-flush">
          <li class="list-group-item {{ $project->title ?? 'text-danger' }}"><strong>Título:</strong>
            {{ $project->title ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->type ?? 'text-danger' }}"><strong>Tipo:</strong>
            {{ $project->type ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->modality ?? 'text-danger' }}"><strong>Modalidade:</strong>
            {{ $project->modality ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->course_name->name ?? 'text-danger' }}"><strong>Curso:</strong>
            {{ $project->course_name->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->user->name ?? 'text-danger' }}"><strong>Orientador:</strong>
            {{ $project->user->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->start_date ? '' : 'text-danger' }}"><strong>Início:</strong>
            {{ $project->start_date ? date('d/m/Y', strtotime($project->start_date)) : 'Vazio' }}</li>
          <li class="list-group-item {{ $project->end_date ? '' : 'text-danger' }}"><strong>Fim:</strong>
            {{ $project->end_date ? date('d/m/Y', strtotime($project->end_date)) : 'Vazio' }}</li>
          <li class="list-group-item"><strong>Status:</strong>
            {{ $project->status == 0 ? 'Inativo' : ($project->status == 1 ? 'Ativo' : 'Finalizado') }}</li>
        </ul>
      </x-slot:content>
    </x-modal.offcanvas>

    <x-modal.offcanvas id="modal-edit-{{ $project->id }}" class="offcanvas-end" title="Editar">
      <x-slot:content>
        <ul class="list-group list-group-flush">
          <li class="list-group-item {{ $project->title ?? 'text-danger' }}"><strong>Título:</strong>
            {{ $project->title ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->type ?? 'text-danger' }}"><strong>Tipo:</strong>
            {{ $project->type ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->modality ?? 'text-danger' }}"><strong>Modalidade:</strong>
            {{ $project->modality ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->course_name->name ?? 'text-danger' }}"><strong>Curso:</strong>
            {{ $project->course_name->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->user->name ?? 'text-danger' }}"><strong>Orientador:</strong>
            {{ $project->user->name ?? 'Vazio' }}</li>
          <li class="list-group-item {{ $project->start_date ? '' : 'text-danger' }}"><strong>Início:</strong>
            {{ $project->start_date ? date('d/m/Y', strtotime($project->start_date)) : 'Vazio' }}</li>
          <li class="list-group-item {{ $project->end_date ? '' : 'text-danger' }}"><strong>Fim:</strong>
            {{ $project->end_date ? date('d/m/Y', strtotime($project->end_date)) : 'Vazio' }}</li>
          <li class="list-group-item"><strong>Status:</strong>
            {{ $project->status == 0 ? 'Inativo' : ($project->status == 1 ? 'Ativo' : 'Finalizado') }}</li>
        </ul>
      </x-slot:content>
    </x-modal.offcanvas>
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
