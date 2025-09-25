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
              <a href="{{ route('projects.index') }}">Trabalhos</a>
            </div>
            <h2 class="page-title">
              Trabalhos
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <a href="{{ route('projects.import') }}" class="btn btn-secondary d-sm-inline-block">
              Importar
            </a>
            <a href="{{ route('projects.create') }}" class="btn btn-primary d-sm-inline-block">
              Adicionar
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="d-flex justify-content-end mb-2">
      <x-table.search route="{{ route('projects.index') }}" action="GET" value="{{ request('search') }}"
        placeholder="Pesquisar..." button="true"></x-table.search>
    </div>
    <div class="card">
      <div class="table-responsive card-body p-0">
        <table class="unded-3 w-100 table table-vcenter exclude table-hover card-table table-striped">
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
                <td>{{ $project->title ? Str::limit($project->title, 50) : 'Vazio' }}</td>
                <td>{{ $project->user ? Str::words($project->user->name, 3) : 'Vazio' }}</td>
                <td>{{ $project->start_date ? date('d/m/Y', strtotime($project->start_date)) : 'Vazio' }}</td>
                <td>{{ $project->end_date ? date('d/m/Y', strtotime($project->end_date)) : 'Vazio' }}</td>
                <td>
                  <x-badge.badge
                    class="{{ $project->status == 0 ? 'bg-danger' : ($project->status == 1 ? 'bg-success' : 'bg-primary') }}">
                    <x-slot:content>
                      {{ $project->status == 0 ? 'Inativo' : ($project->status == 1 ? 'Ativo' : 'Finalizado') }}
                    </x-slot:content>
                  </x-badge.badge>
                </td>
                <td>
                  <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-secondary"><i
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
  @endforeach
@endsection
@section('scripts')
@endsection
