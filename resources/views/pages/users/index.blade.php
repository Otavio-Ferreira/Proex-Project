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
              <a href="{{ route('users.index') }}">Usuários</a>
            </div>
            <h2 class="page-title">
              Usuários
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
              data-bs-target="#modal-add-user">
              <i class="icon ti ti-user-plus"></i>
              Adicionar usuário
            </a>
            <div class="d-flex align-items-center">
              <div class="input-icon me-2">
                <input type="text" value="" id="customFilter" class="form-control" placeholder="Pesquisar ...">
                <span class="input-icon-addon">
                  <i class="ti icon text-primary ti-search"></i>
                </span>
              </div>
            </div>
            <x-modal.modal route="{{ route('users.store') }}" id="modal-add-user" class="modal-dialog-centered"
              title="Adicionar usuário" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
              typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
              <x-slot:content>
                @include('components.form-elements.input.input', [
                    'title' => 'Nome',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'name',
                    'required' => 'true',
                    'placeholder' => 'Digite o nome do usuário',
                ])
                @include('components.form-elements.input.input', [
                    'title' => 'Email',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'email',
                    'required' => 'true',
                    'placeholder' => 'Digite o email do usuário',
                ])
                <x-form-elements.select.select title="Grupo de permissões" id="role" name="role">
                  <x-slot:options>
                    <option value="" selected>Selecione</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role->name }}">{{ $role->name }}</option>
                    @endforeach
                  </x-slot:options>
                </x-form-elements.select.select>
              </x-slot:content>
            </x-modal.modal>
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
              <th>Nome</th>
              {{-- <th>Email</th> --}}
              {{-- <th>Perfil</th> --}}
              <th>Curso</th>
              <th>Siape</th>
              <th>Grupo</th>
              <th>Status</th>
              <th width="5%"></th>
              <th width="5%"></th>
              <th width="5%"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                {{-- <td>{{ $user->email }}</td> --}}
                {{-- <td>{{ $user->persons->coordinator_profile ?? 'Não informado' }}</td> --}}
                <td>{{ $user->persons->course->name ?? 'Não informado' }}</td>
                <td>{{ $user->persons->coordinator_siape ?? 'Não informado' }}</td>
                <td>{{ $user->roles->first()->name }}</td>
                <td>
                  <x-badge.badge class="{{ $user->status == 1 ? 'bg-success' : 'bg-danger' }}">
                    <x-slot:content>
                      {{ $user->status == 1 ? 'Ativo' : 'Inativo' }}
                    </x-slot:content>
                  </x-badge.badge>
                </td>
                <td>
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
                </td>
                <td>
                  <button class="btn btn-azure" data-bs-toggle="offcanvas"
                    data-bs-target="#modal-details-{{ $user->id }}"><i class="ti ti-dots-vertical"></i></button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @foreach ($users as $user)
    <x-modal.offcanvas id="modal-details-{{ $user->id }}" class="offcanvas-end" title="{{ $user->name }}">
      <x-slot:content>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
          <li class="list-group-item"><strong>Perfil:</strong> {{ $user->persons->coordinator_profile ?? 'Não informado' }}</li>
          <li class="list-group-item"><strong>Curso:</strong> {{ $user->persons->course->name ?? 'Não informado' }}</li>
          <li class="list-group-item"><strong>Siape:</strong> {{ $user->persons->coordinator_siape ?? 'Não informado' }}</li>
          <li class="list-group-item"><strong>Grupo:</strong> {{ $user->roles->first()->name }}</li>
          <li class="list-group-item"><strong>Status:</strong> {{ $user->status == 1 ? 'Ativo' : 'Inativo' }}</li>
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
