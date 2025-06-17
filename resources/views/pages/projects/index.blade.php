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
            <a href="{{route('projects.create')}}" class="btn btn-primary d-sm-inline-block">
              Adicionar projeto
            </a>
            <div class="d-flex align-items-center">
              <div class="input-icon me-2">
                <input type="text" value="" id="customFilter" class="form-control" placeholder="Pesquisar ...">
                <span class="input-icon-addon">
                  <i class="ti icon text-primary ti-search"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="">
      <div class="table-responsive">
        <table class="border unded-3 w-100 table table-vcenter exclude bg-white  card-table table-striped" id="userTable">
          <thead>
            <tr>
              <th>Título</th>
              {{-- <th width="5%"></th>
              <th width="5%"></th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($projects as $project)
              <tr>
                <td>{{ $project->title }}</td>
                {{-- <td>
                  <x-badge.badge class="{{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                    <x-slot:content>
                      {{ $user->status == 1 ? 'Ativo' : 'Inativo' }}
                    </x-slot:content>
                  </x-badge.badge>
                </td> --}}
                {{-- <td>
                  <button class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#modal-edit-user{{ $user->id }}"><i class="ti ti-edit"></i></button>
                  <x-modal.modal route="{{ route('users.update', $user->id) }}" id="modal-edit-user{{ $user->id }}"
                    class="modal-dialog-centered" title="Editar usuário" typeBtnClose="button" classBtnClose="me-auto"
                    textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                    <x-slot:content>
                      @include('components.form-elements.input.input', [
                          'title' => 'Nome',
                          'type' => 'text',
                          'class' => 'mb-3',
                          'name' => 'name',
                          'required' => 'true',
                          'value' => $user->name,
                      ])

                      <x-form-elements.select.select title="Status" id="status" name="status">
                        <x-slot:options>
                          <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Ativo</option>
                          <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inativo</option>
                        </x-slot:options>
                      </x-form-elements.select.select>

                      <x-form-elements.select.select title="Grupo de permissões" id="role" name="role">
                        <x-slot:options>
                          @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                              {{ $role->name == $user->roles->first()->name ? 'selected' : '' }}>{{ $role->name }}
                            </option>
                          @endforeach
                        </x-slot:options>
                      </x-form-elements.select.select>
                    </x-slot:content>
                  </x-modal.modal>
                </td>
                <td>
                  <button class="btn btn-danger" data-bs-toggle="modal"
                    data-bs-target="#modal-delete-user{{ $user->id }}"><i class="ti ti-trash"></i></button>

                  <x-modal.modal-alert route="{{ route('users.destroy', $user->id) }}"
                    id="modal-delete-user{{ $user->id }}" class="modal-dialog-centered modal-sm"
                    background="bg-danger" classBody="text-center py-4" title="Excluír usuário" typeBtnClose="button"
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
                </td> --}}
              </tr>
            @endforeach
          </tbody>
        </table>
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
@endsection
