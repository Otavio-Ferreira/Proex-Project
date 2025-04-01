@extends('templates.template')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/styleDataTable.css') }}">
  <style>
    #table thead th {
      white-space: nowrap;
      /* Evita que o cabeçalho seja quebrado */
      width: auto;
      /* Permite que a largura seja determinada pelo conteúdo */
    }

    #table tbody td {
      white-space: nowrap;
      /* Evita quebra de texto nas células */
    }

    #table {
      table-layout: fixed;
      /* Garante que as colunas do thead e tbody tenham a mesma largura */
      width: 100%;
    }
  </style>
@endsection
@section('content')
  <div class="page-header">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-md">
          <div class="page-pretitle">
            <a href="{{ route('forms.create') }}">Formulários</a> /
            <a href="{{ route('forms.show', $form->id) }}">Relatório personalizado</a>
          </div>
          <h2 class="page-title">
            Relatório personalizado
          </h2>
        </div>
        <div class="d-flex align-items-center col-sm-12 col-md-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body container-xl">
    <form action="{{ route('form.report', $form->id) }}" method="post" class="row">
      @csrf
      <div class="col-12 p-2">
        <div class="card mb-2 border-top-0 border-end-0 border-bottom-0 border-4 border-muted">
          <div class="card-body">
            <label class="form-label">Selecione os campos adicionais das respostas que devem ser exibidos no
              relatório</label>
            <div class="d-flex flex-wrap mt-3">
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="additional_fields[]" value="activitys" type="checkbox">
                <span class="form-check-label">Atividades</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="additional_fields[]" value="internal_partners" type="checkbox">
                <span class="form-check-label">Parceiros internos</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="additional_fields[]" value="external_partners" type="checkbox">
                <span class="form-check-label">Parceiros externos</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="additional_fields[]" value="extension_actions" type="checkbox">
                <span class="form-check-label">Ações</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="additional_fields[]" value="social_medias" type="checkbox">
                <span class="form-check-label">Redes sociais</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="additional_fields[]" value="images" type="checkbox">
                <span class="form-check-label">Imagens</span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 p-2">
        <div class="card mb-2 border-top-0 border-end-0 border-bottom-0 border-4 border-muted">
          <div class="card-body">
            <label class="form-label required">Selecione os status das respostas que devem ser exibidos no
              relatório</label>
            <div class="d-flex flex-wrap mt-3">
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="status[]" value="0" type="checkbox">
                <span class="form-check-label">Em andamento</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="status[]" value="1" type="checkbox">
                <span class="form-check-label">Enviados</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="status[]" value="2" type="checkbox">
                <span class="form-check-label">Em revisão</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="status[]" value="3" type="checkbox">
                <span class="form-check-label">Corrigidos</span>
              </label>
              <label class="form-check form-switch form-switch-2 me-3">
                <input class="form-check-input" name="status[]" value="4" type="checkbox">
                <span class="form-check-label">Aprovados</span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 p-2">
        <div class="card border-top-0 border-end-0 border-bottom-0 border-4 border-muted">
          <div class="card-body">
            <x-form-elements.select.select title="Deseja trazer os dados de todas as respostas?" id="role"
              name="all">
              <x-slot:options>
                <option value="" selected disabled>Selecione</option>
                <option value="false">Não</option>
                <option value="true">Sim</option>
              </x-slot:options>
            </x-form-elements.select.select>

            <div id="comment" style="display: none;">
              <hr class="mb-2 mt-2">
              <label class="form-label">Selecione os projetos para o relatório</label>
              <div class="d-flex align-items-center mb-2 w-100">
                <div class="input-icon w-100">
                  <input type="text" value="" id="customFilter" class="form-control"
                    placeholder="Título do projeto">
                  <span class="input-icon-addon">
                    <i class="ti icon text-primary ti-search"></i>
                  </span>
                </div>
              </div>
              <div class="mb-3">
                <div class="card overflow-auto" style="">
                  <table class="table table-vcenter mt-0 exclude" id="myTable">
                    <thead class="">
                      <tr>
                        <th>Nome</th>
                        <th>Professor</th>
                        <th width="10%"></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($form->responses as $response)
                        <tr>
                          <td>{{ $response->action->title }}</td>
                          <td>{{ $response->coordinator_name }}</td>
                          <td>
                            <span class="col-auto">
                              <label class="form-check form-check-single form-switch">
                                <input class="form-check-input" name="projects[]" value="{{ $response->id }}"
                                  type="checkbox">
                              </label>
                            </span>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-flex mt-2">
        <button type="submit" class="btn btn-muted ms-auto">
          <i class="ti ti-file-type-pdf icon"></i>
          Gerar relatório
        </button>
      </div>
    </form>
  </div>
@endsection
@section('scripts')
  <script>
    // document.addEventListener("DOMContentLoaded", function() {
    //   var el = document.getElementById('select_project');
    //   if (el) {
    //     new TomSelect(el, {
    //       copyClassesToDropdown: false,
    //       dropdownParent: 'body',
    //       controlInput: '<input>',
    //       render: {
    //         item: function(data, escape) {
    //           return `<div>${escape(data.text)}</div>`;
    //         },
    //         option: function(data, escape) {
    //           return `<div>${escape(data.text)}</div>`;
    //         }
    //       }
    //     });
    //   }
    // });

    document.getElementById('role').addEventListener('change', function() {
      var commentDiv = document.getElementById('comment');
      var roleValue = this.value;

      if (roleValue == 'false') {
        commentDiv.style.display = 'block';
      } else {
        commentDiv.style.display = 'none';
      }
    });

    if (document.getElementById('role').value == '2') {
      document.getElementById('comment').style.display = 'block';
    }
  </script>

  <script src="{{ asset('assets/js/kanban/dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/kanban/startDataTable.js') }}"></script>
  <script>
    $(document).ready(function() {
      var table = $('#myTable').DataTable({
        info: false,
        ordering: false,
        paging: true,
        searching: true,
        autoWidth: false,
        scrollCollapse: false,
        border: false,
        lengthChange: false, // Remove o seletor de quantidade de registros
        pagingType: 'simple_numbers', // Exemplo de tipo de paginação, pode ser customizado
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
