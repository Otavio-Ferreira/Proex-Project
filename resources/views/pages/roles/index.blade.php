@extends('templates.template')

@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('roles.index') }}">Grupos</a>
          </div>
          <h2 class="page-title">
            Grupos
          </h2>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
              data-bs-target="#modal-add-role">
              <i class="icon ti ti-plus"></i>
              Adicionar grupo
            </a>
            <x-modal.modal route="{{ route('roles.store') }}" id="modal-add-role" class="modal-dialog-centered"
              title="Adicionar grupo" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
              typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
              <x-slot:content>
                @include('components.form-elements.input.input', [
                    'title' => 'Nome do grupo',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'name',
                    'required' => 'true',
                    'placeholder' => 'Adicone um nome para o grupo de usuário',
                ])
                <div class="">
                  <label class="form-label">Permissões</label>
                  <div class="card overflow-auto" style="height: 300px;">
                    <x-table.table tableClass="table-vcenter card-table table-striped">
                      <x-slot:ths>
                        <th>Nome</th>
                        <th width="10%"></th>
                      </x-slot:ths>
                      <x-slot:trs>
                        @foreach ($permissions as $permission)
                          <tr>
                            <td>{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</td>
                            <td>
                              <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" name="permission_selected[]"
                                    value="{{ $permission->name }}" type="checkbox">
                                </label>
                              </span>
                            </td>
                          </tr>
                        @endforeach
                      </x-slot:trs>
                    </x-table.table>
                  </div>
                </div>
              </x-slot:content>
            </x-modal.modal>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="card">
      <div class="table-responsive">
        <x-table.table tableClass="table-vcenter card-table table-striped">
          <x-slot:ths>
            <th>Nome</th>
            <th width="10%"></th>
          </x-slot:ths>
          <x-slot:trs>
            @foreach ($roles as $role)
              <tr>
                <td>{{ ucwords($role->name) }}</td>
                <td>
                  <button class="btn " data-bs-toggle="modal"
                    data-bs-target="#modal-edit-role{{ $role->id }}">Editar</button>
                  <x-modal.modal route="{{ route('roles.update', $role->id) }}" id="modal-edit-role{{ $role->id }}"
                    class="modal-dialog-centered" title="Editar grupo" typeBtnClose="button" classBtnClose="me-auto"
                    textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                    <x-slot:content>
                      @include('components.form-elements.input.input', [
                          'title' => 'Nome do grupo',
                          'type' => 'text',
                          'class' => 'mb-3',
                          'name' => 'name',
                          'required' => 'true',
                          'value' => $role->name,
                      ])
                      <div class="card overflow-auto" style="height: 300px;">
                        <x-table.table tableClass="table-vcenter card-table table-striped">
                          <x-slot:ths>
                <th>Nome</th>
                <th width="10%"></th>
          </x-slot:ths>
          <x-slot:trs>
            @foreach ($permissions as $permission)
              <tr>
                <td>{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</td>
                <td>
                  <span class="col-auto">
                    <label class="form-check form-check-single form-switch">
                      <input class="form-check-input" name="permission_selected[]" value="{{ $permission->name }}"
                        type="checkbox" @if ($role->permissions->contains($permission)) checked @endif>
                    </label>
                  </span>
                </td>
              </tr>
            @endforeach
          </x-slot:trs>
        </x-table.table>
      </div>
      </x-slot:content>
      </x-modal.modal>
      </td>
      </tr>
      @endforeach
      </x-slot:trs>
      </x-table.table>
    </div>
  </div>
  </div>
@endsection
