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
              <a href="{{ route('logs.index') }}">Logs</a>
            </div>
            <h2 class="page-title">
              Todos os logs
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <form method="GET" action="{{ route('logs.index') }}" class="w-100">
              <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">
                <div class="input-icon w-100">
                  <input type="text" name="search" class="form-control" placeholder="Pesquisar log..."
                    value="{{ request('search') }}">
                  <span class="input-icon-addon">
                    <i class="ti icon text-primary ti-search"></i>
                  </span>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="">
      <div class="table-responsive">
        <x-table.table tableClass="border unded-3 w-100 table table-vcenter exclude table-hover card-table table-striped">
          <x-slot:ths>
            <th>Agente</th>
            <th>Evento</th>
            <th>Data</th>
            <th>Modal</th>
            <th width="5%"></th>
          </x-slot:ths>
          <x-slot:trs>
            @foreach ($logs as $log)
              <tr>
                <td>{{ optional($log->causer)->name ?? 'Sistema' }}</td>
                <td>{{ $log->event }}</td>
                <td>{{ date('d/m/Y H:i:s', strtotime($log->created_at)) }}</td>
                <td>{{ $log->subject_type }}</td>
                <td>
                  <button class="btn btn-secondary" data-bs-target="#modal-details{{ $log->id }}"
                    data-bs-toggle="offcanvas" aria-controls="offcanvasExample"><i
                      class="ti ti-list-details icon "></i>Detalhes</button>
                </td>
              </tr>
            @endforeach
          </x-slot:trs>
        </x-table.table>

      </div>
      <div class="d-flex justify-content-center mt-3">
        {{ $logs->links() }}
      </div>
    </div>
    @foreach ($logs as $log)
      <div class="offcanvas offcanvas-end" tabindex="-1" id="modal-details{{ $log->id }}"
        aria-labelledby="modal_details">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="modal_details">Detalhes do log do
            {{ optional($log->causer)->name ?? 'Sistema' }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="fw-bold">
            Data: {{ date('d/m/Y H:i:s', strtotime($log->created_at)) }}
          </div>
          <div class="dropdown mt-3">
            @if ($log->properties)
              @if (!empty($log->properties['old']))
                <label><strong>Antes:</strong></label>
                <pre>{{ json_encode($log->properties['old'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
              @endif

              @if (!empty($log->properties['attributes']))
                <label><strong>{{ !empty($log->properties['old']) ? 'Depois' : 'Detalhes' }}</strong></label>
                <pre>{{ json_encode($log->properties['attributes'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
              @endif
            @endif
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
@section('scripts')
@endsection
{
    "attributes": {
        "name": "JOSE GLADSTONE ALMEIDA JUNIOR",
        "email": "jose.gladstone@ufca.edu.br",
        "status": 2,
        "active_role": null
    }
}