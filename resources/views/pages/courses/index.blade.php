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
              <a href="{{ route('courses.index') }}">Cursos</a>
            </div>
            <h2 class="page-title">
              Cursos
            </h2>
          </div>
        </div>
        <div class="col-auto ms-auto">
          <div class="btn-list">
            <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
              data-bs-target="#modal-add-course">
              Adicionar curso
            </a>
            <div class="d-flex align-items-center">
              <div class="input-icon me-2">
                <input type="text" value="" id="customFilter" class="form-control" placeholder="Pesquisar ...">
                <span class="input-icon-addon">
                  <i class="ti icon text-primary ti-search"></i>
                </span>
              </div>
            </div>
            <x-modal.modal route="{{ route('courses.store') }}" id="modal-add-course" class="modal-dialog-centered"
              title="Adicionar curso" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
              typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
              <x-slot:content>
                @include('components.form-elements.input.input', [
                    'title' => 'Nome do curso',
                    'type' => 'text',
                    'class' => 'mb-3',
                    'name' => 'name',
                    'required' => 'true',
                    'placeholder' => 'Digite o nome do curso',
                ])
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
        <table class="border unded-3 w-100 table table-vcenter exclude bg-white  card-table table-striped"
          id="courseTable">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Status</th>
              <th width="5%"></th>
            </tr>
          </thead>
          <tbody>
            @foreach ($courses as $course)
              <tr>
                <td>{{ $course->name }}</td>
                <td>
                  <x-badge.badge
                    class="{{ $course->status == 0 ? 'bg-danger' : ($course->status == 1 ? 'bg-success' : 'bg-primary') }}">
                    <x-slot:content>
                      {{ $course->status == 0 ? 'Inativo' : ($course->status == 1 ? 'Ativo' : 'Finalizado') }}
                    </x-slot:content>
                  </x-badge.badge>
                </td>
                <td>
                  <button class="btn btn-secondary" data-bs-toggle="modal"
                    data-bs-target="#modal-edit-course{{ $course->id }}"><i class="ti ti-edit"></i></button>
                  <x-modal.modal route="{{ route('courses.update', $course->id) }}"
                    id="modal-edit-course{{ $course->id }}" class="modal-dialog-centered" title="Editar curso"
                    typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar" typeBtnSave="submit"
                    classBtnSave="btn-primary" textBtnSave="Salvar">
                    <x-slot:content>
                      @include('components.form-elements.input.input', [
                          'title' => 'Nome do curso',
                          'type' => 'text',
                          'class' => 'mb-3',
                          'name' => 'name',
                          'required' => 'true',
                          'value' => $course->name,
                      ])
                      <x-form-elements.select.select title="Status" id="status" name="status">
                        <x-slot:options>
                          <option value="1" {{ $course->status == 1 ? 'selected' : '' }}>Ativo</option>
                          <option value="0" {{ $course->status == 0 ? 'selected' : '' }}>Inativo</option>
                        </x-slot:options>
                      </x-form-elements.select.select>
                    </x-slot:content>
                  </x-modal.modal>
                </td>
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
      var table = $('#courseTable').DataTable({
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
