@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="col">
            <div class="page-pretitle">
              <a href="{{ route('projects.my') }}">Meus Trabalhos</a>
            </div>
            <h2 class="page-title">
              Meus Trabalhos
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="d-flex justify-content-end mb-2">
      <x-table.search route="{{ route('projects.my') }}" action="GET" value="{{ request('search') }}"
        placeholder="Pesquisar por fomulário" button="true"></x-table.search>
    </div>
    <div class="">
      <div class="card">
        <div class="card-body p-0">
          <table class="unded-3 w-100 table table-vcenter exclude table-hover card-table table-striped">
            <thead>
              <th>Título</th>
              <th>Início</th>
              <th>Fim</th>
              <th>Status</th>
              <th width="5%"></th>
              <th width="5%"></th>
            </thead>
            <tbody>
              @foreach ($projects as $project)
                <tr>
                  <td>{{ $project->title }}</td>
                  <td>
                    {{ date('d/m/Y', strtotime($project->start_date)) }}
                  </td>
                  <td>
                    {{ date('d/m/Y', strtotime($project->end_date)) }}
                  </td>
                  <td>
                    <x-badge.badge class="{{ $project->status == 1 ? 'bg-success' : ($project->status == 2 ? 'bg-primary' : 'bg-danger') }}">
                      <x-slot:content>
                        {{ $project->status == 1 ? 'Ativo' : ($project->status == 2 ? 'Finalizado' : 'Inativo') }}
                      </x-slot:content>
                    </x-badge.badge>
                  </td>
                  <td><a class="btn p-1 px-2 rounded-2 btn-yellow btn-sm" data-bs-toggle="offcanvas"
                      data-bs-target="#modal-reports-{{ $project->id }}">Relatórios</a>
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
    </div>
    <div class="d-flex justify-content-center mt-5">
      {{ $projects->links() }}
    </div>
  </div>
  @foreach ($projects as $project)
    <x-modal.offcanvas id="modal-details-{{ $project->id }}" class="offcanvas-end" title="{{ $project->title }}">
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
    <x-modal.offcanvas id="modal-reports-{{ $project->id }}" class="offcanvas-end"
      title="Relatórios: {{ $project->title }}">
      <x-slot:content>
        <ol class="list-group list-group-numbered">
          @foreach ($project->responses as $response)
            <a href="{{ route('response.index', $response->id) }}" class="text-decoration-none">
              <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                  <div class="fw-bold">{{ $response->form->title }}</div>
                  Prazo: {{ date('d/m/Y', strtotime($response->form->date)) }}
                </div>
                <span class="badge text-bg-{{ $response->form->status == 1 ? 'success' : 'red' }} rounded-pill">
                  @if ($response->form->status == 1)
                    Ativo
                  @else
                    Inativo
                  @endif
                </span>
              </li>
            </a>
          @endforeach
        </ol>
      </x-slot:content>
    </x-modal.offcanvas>
  @endforeach
@endsection
@section('scripts')
@endsection
