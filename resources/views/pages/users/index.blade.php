@extends('templates.template')

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
    <div class="card">
      <div class="table-responsive">
        <x-table.table tableClass="table-vcenter card-table table-striped">
          <x-slot:ths>
            <th>Nome</th>
            <th>Email</th>
            <th>Grupo</th>
            <th>Status</th>
            <th width="5%"></th>
            <th width="5%"></th>
          </x-slot:ths>
          <x-slot:trs>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
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
                          <option value="1" {{ $user->STATUS == 1 ? 'selected' : '' }}>Ativo</option>
                          <option value="0" {{ $user->STATUS == 0 ? 'selected' : '' }}>Inativo</option>
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
              </tr>
            @endforeach
          </x-slot:trs>
        </x-table.table>
      </div>
    </div>
  </div>
@endsection
