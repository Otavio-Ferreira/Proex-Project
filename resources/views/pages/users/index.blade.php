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

                <div class="mb-3">
                  <div class="form-label">Selecione quais portais o usuário terá acesso</div>
                  <div>
                    @foreach ($roles as $role)
                      <label class="form-check">
                        <input value="{{ $role->name }}" name="role[]" class="form-check-input" type="checkbox">
                        <span class="form-check-label">{{ $role->name }}</span>
                      </label>
                    @endforeach
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
    <div class="d-flex justify-content-end mb-2">
      <x-table.search route="{{ route('users.index') }}" action="GET" value="{{ request('search') }}"
        placeholder="Pesquisar..." button="true"></x-table.search>
    </div>
    <div class="card">
      <div class="table-responsive card-body p-0">
        <table class="unded-3 w-100 table table-vcenter exclude table-hover card-table table-striped">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Email</th>
              {{-- <th>Perfil</th> --}}
              {{-- <th>Curso</th> --}}
              <th>Siape</th>
              {{-- <th>Grupo</th> --}}
              <th>Status</th>
              <th width="5%"></th>
              <th width="5%"></th>
              {{-- <th width="5%"></th> --}}
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                {{-- <td>{{ $user->persons->coordinator_profile ?? 'Não informado' }}</td> --}}
                {{-- <td>{{ $user->persons->course->name ?? 'Não informado' }}</td> --}}
                <td>{{ $user->persons->coordinator_siape ?? 'Não informado' }}</td>
                {{-- <td>{{ $user->roles->first()->name }}</td> --}}
                <td>
                  <x-badge.badge class="bg-{{ $status[$user->status]['color'] }}">
                    <x-slot:content>
                      {{ $status[$user->status]['name'] }}
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
                          <option value="2" {{ $user->status == 2 ? 'selected' : '' }}>Pré-Cadastrado</option>
                        </x-slot:options>
                      </x-form-elements.select.select>

                      <div class="mb-3">
                        <div class="form-label">Selecione quais portais o usuário terá acesso</div>
                        <div>
                          @foreach ($roles as $role)
                            <label class="form-check">
                              <input value="{{ $role->name }}" name="role[]" class="form-check-input" type="checkbox"
                                {{ $user->roles->contains($role) ? 'checked' : '' }}>
                              <span class="form-check-label">{{ $role->name }}</span>
                            </label>
                          @endforeach
                        </div>
                      </div>
                    </x-slot:content>
                  </x-modal.modal>
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
    <div class="d-flex justify-content-center mt-5">
      {{ $users->links() }}
    </div>
  </div>
  @foreach ($users as $user)
    <x-modal.offcanvas id="modal-details-{{ $user->id }}" class="offcanvas-end" title="{{ $user->name }}">
      <x-slot:content>
        <ul class="list-group list-group-flush">
          <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
          <li class="list-group-item"><strong>Perfil:</strong>
            {{ $user->persons->coordinator_profile ?? 'Não informado' }}</li>
          <li class="list-group-item"><strong>Curso:</strong> {{ $user->persons->course->name ?? 'Não informado' }}</li>
          <li class="list-group-item"><strong>Siape:</strong> {{ $user->persons->coordinator_siape ?? 'Não informado' }}
          </li>
          <li class="list-group-item"><strong>Grupo:</strong> {{ $user->roles->first()->name }}</li>
          <li class="list-group-item"><strong>Status:</strong> {{ $user->status == 1 ? 'Ativo' : 'Inativo' }}</li>
        </ul>
      </x-slot:content>
    </x-modal.offcanvas>
  @endforeach
@endsection
@section('scripts')
@endsection
