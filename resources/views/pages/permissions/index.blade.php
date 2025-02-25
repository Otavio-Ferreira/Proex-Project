@extends('templates.template')

@section('content')
<div class="page-header d-print-none">
  <div class="">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Permissões
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none">
        <div class="btn-list">
          <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-add-permission">
            <i class="icon ti ti-plus"></i>
            Adicionar permissão
          </a>
          <x-modal.modal route="{{route('permissions.store')}}" id="modal-add-permission" class="modal-dialog-centered" title="Adicionar permissão" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
            <x-slot:content>
              @include('components.form-elements.input.input', [
              'title' => 'Nome da permissão',
              'type' => 'text',
              'name' => 'name',
              'required' => 'true'
              ])
            </x-slot:content>
          </x-modal.modal>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="table-responsive">
    <div class="card">
      <x-table.table tableClass="table-vcenter card-table table-striped">
        <x-slot:ths>
          <th>Nome</th>
          <th width="10%"></th>
        </x-slot:ths>
        <x-slot:trs>
          @foreach($permissions as $permission)
          <tr>
            <td>{{ $permission->name }}</td>
            <td>
              <button class="btn " data-bs-toggle="modal" data-bs-target="#modal-edit-permission{{$permission->id}}">Editar</button>
              <x-modal.modal route="{{route('permissions.update', $permission->id)}}" id="modal-edit-permission{{$permission->id}}" class="modal-dialog-centered" title="Editar permissão" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.input.input', [
                  'title' => 'Nome da permissão',
                  'type' => 'text',
                  'name' => 'name',
                  'required' => 'true',
                  'value' => $permission->name
                  ])
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