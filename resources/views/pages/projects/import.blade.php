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
              <a href="{{ route('projects.index') }}">Trabalhos</a> /
              <a href="{{ route('projects.import') }}">Importar</a>
            </div>
            <h2 class="page-title">
              Importar trabalhos
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <button class="btn btn-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
              aria-expanded="false" aria-controls="collapseExample">
              <i class="icon ti ti-info-circle m-auto"></i>
            </button>
            <a href="{{ route('projects.index') }}" class="btn btn-cyan">Voltar</a>
          </div>
        </div>
      </div>
      <div class="collapse mt-2" id="collapseExample">
        <div class="card card-body">
          <h3>Atenção para a Importação de Dados</h3>
          <p>Para importar os dados corretamente, o seu arquivo .csv deve conter as
            seguintes colunas, na ordem exata especificada abaixo:</p>
          <div class="mb-2">
            <span class="badge badge-dark">ID Projeto</span>
            <span class="badge badge-dark">Título</span>
            <span class="badge badge-dark">Coordenador</span>
            <span class="badge badge-dark">SIAPE</span>
            <span class="badge badge-dark">Centro/Departamento</span>
            <span class="badge badge-dark">Data Inicio</span>
            <span class="badge badge-dark">Data Fim</span>
            <span class="badge badge-dark">Ano</span>
            <span class="badge badge-dark">Tipo Ação</span>
            <span class="badge badge-dark">Area Tematica</span>
            <span class="badge badge-dark">Modalidade</span>
          </div>
          <p><strong class="text-danger">Importante:</strong> Certifique-se de que o cabeçalho do seu arquivo .csv corresponda exatamente a estes nomes para evitar erros durante o processo de importação.</p>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="tab-content" id="tabContent">
      <div class="tab-pane fade show active" id="pdf-tab-pane" role="tabpanel" aria-labelledby="pdf-tab" tabindex="0">
        <form action="{{ route('projects.storeImport') }}" id="form-create" method="post" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-12 col-md-4">
              <div id="drop-area"
                class="rounded-4 d-flex flex-column justify-content-center align-items-center bg-light p-4 text-center"
                style="height: 250px; cursor: pointer; border: dashed 2px gray">
                <p class="fw-semibold mb-2" id="drop-label">Vamos importar dados em massa!
                </p>
                <p class="text-muted mb-2">Arraste o .csv aqui ou clique para selecionar</p>
                <p class="text-red mb-2">Máximo 10MB</p>
                <input type="file" name="csv" id="csv" accept=".csv" required hidden>
                <div id="file-info" class="text-muted small mt-2"></div>
              </div>
              <div class="d-flex justify-content-end mt-2">
                <button type="submit" class="btn btn-secondary">Enviar</button>
              </div>
            </div>
            <div class="col-12 col-md-8">
              <div class="table-responsive">
                <h3 class="mb-2">Histórico de importações</h3>
                <hr class="mt-0 mb-3">
                <table class="border bg-blue w-100 table table-vcenter exclude bg-white  card-table table-striped">
                  <thead>
                    <tr>
                      <th>Período de importação</th>
                      <th width="5%">Quantidade importada</th>
                      <th></th>
                      <th width="5%"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($projects as $project)
                      <tr>
                        <td>
                          {{ date('d/m/Y', strtotime($project['first_date'])) . ' (' . date('H:i:s', strtotime($project['first_date'])) . '-' . date('H:i:s', strtotime($project['last_date'])) . ')' }}
                        </td>
                        <td>{{ $project['qtd'] }}</td>
                        <td>{{ $project['msg'] }}</td>
                        <td>
                          <a href="{{ route('projects.analysis', $project['id_submit']) }}" class="btn btn-secondary">
                            <i class="ti ti-edit"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
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
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const dropArea = document.getElementById("drop-area");
      const csvInput = document.getElementById("csv");
      const fileInfo = document.getElementById("file-info");

      const MAX_SIZE_MB = 10;

      function handleFile(file) {
        if (!file) return;

        // Verifica se é CSV
        if (!file.name.endsWith(".csv")) {
          fileInfo.textContent = "Por favor, selecione um arquivo CSV válido.";
          csvInput.value = "";
          return;
        }

        const sizeMB = file.size / (1024 * 1024);
        if (sizeMB > MAX_SIZE_MB) {
          fileInfo.textContent = "O arquivo ultrapassa 10MB.";
          csvInput.value = "";
          return;
        }

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        csvInput.files = dataTransfer.files;

        fileInfo.textContent = `Selecionado: ${file.name} (${sizeMB.toFixed(2)}MB)`;
      }

      dropArea.addEventListener("click", () => {
        csvInput.value = "";
        csvInput.click();
      });

      csvInput.addEventListener("change", () => {
        const file = csvInput.files[0];
        handleFile(file);
      });

      dropArea.addEventListener("dragover", (e) => {
        e.preventDefault();
        dropArea.classList.add("dragover");
      });

      dropArea.addEventListener("dragleave", () => {
        dropArea.classList.remove("dragover");
      });

      dropArea.addEventListener("drop", (e) => {
        e.preventDefault();
        dropArea.classList.remove("dragover");
        const file = e.dataTransfer.files[0];
        handleFile(file);
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('form-create');
      const overlay = document.getElementById('loading-overlay');

      form.addEventListener('submit', function() {
        overlay.style.display = 'flex';
      });
    });
  </script>
@endsection
