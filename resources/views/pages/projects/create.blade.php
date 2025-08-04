@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('projects.index') }}">Trabalhos</a>/
            <a href="{{ route('projects.create') }}">Adicionar</a>
          </div>
          <h2 class="page-title">
            Adicionar trabalho
          </h2>
        </div>
        <div class="col-auto ms-auto">
            <a href="{{route('projects.index')}}" class="btn btn-cyan">Voltar</a>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('projects.store') }}" method="post" class="row">
            @csrf

            <div class="col-12 col-md-6">
              @include('components.form-elements.input.input', [
                  'title' => 'Título',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'title',
                  'required' => 'true',
                  'placeholder' => 'Digite o título',
                  'value' => old('title') ?? '',
              ])

              <div class="mb-3">
                <label class="form-label required">Tipo</label>
                <select class="form-select" id="type" name="type" required>
                  <option value="" selected disabled>Selecione</option>
                  <option value="Programa" {{ old('type') ? (old('type') == 'Programa' ? 'selected' : '') : '' }}>
                    Programa</option>
                  <option value="Projeto" {{ old('type') ? (old('type') == 'Projeto' ? 'selected' : '') : '' }}>
                    Projeto
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label required">Modalidade</label>
                <select class="form-select" id="modality" name="modality" required>
                  <option value="" selected disabled>Selecione</option>
                  <option value="UFCA Itinerante"
                    {{ old('modality') ? (old('modality') == 'UFCA Itinerante' ? 'selected' : '') : ' ' }}>
                    UFCA Itinerante</option>

                  <option value="Ampla Concorrência"
                    {{ old('modality') ? (old('modality') == 'Ampla Concorrência' ? 'selected' : '') : ' ' }}>
                    Ampla Concorrência</option>

                  <option value="PROPE" {{ old('modality') ? (old('modality') == 'PROPE' ? 'selected' : '') : ' ' }}>
                    PROPE</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label required">Curso</label>
                <select class="form-select" id="select-courses" name="course" required>
                  <option value="" selected disabled>Selecione</option>
                  @foreach ($courses as $base_course)
                    <option value="{{ $base_course->id }}"
                      {{ old('course') ? (old('course') == $base_course->id ? 'selected' : '') : ' ' }}>
                      {{ $base_course->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="mb-3">
                <label class="form-label">Professor/Orientador</label>
                <select class="form-select" id="teachers" name="teacher">
                  <option value="" selected disabled>Selecione</option>
                  @foreach ($teachers as $teacher)
                    <option value="{{ $teacher->id }}"
                      {{ old('teacher') ? (old('teacher') == $teacher->id ? 'selected' : '') : ' ' }}>
                      {{ $teacher->name }}</option>
                  @endforeach
                </select>
              </div>

              @include('components.form-elements.input.input', [
                  'title' => 'Data de início',
                  'type' => 'date',
                  'class' => 'mb-3',
                  'name' => 'start_date',
                  'required' => 'true',
                  'value' => old('start_date') ?? '',
              ])

              @include('components.form-elements.input.input', [
                  'title' => 'Data de término',
                  'type' => 'date',
                  'class' => 'mb-3',
                  'name' => 'end_date',
                  'required' => 'true',
                  'value' => old('end_date') ?? '',
              ])

              <div class="mb-3">
                <label class="form-label required">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="" selected disabled>Selecione</option>
                  <option value="0" {{ old('status') ? (old('status') == '0' ? 'selected' : '') : ' ' }}>
                    Inativo</option>

                  <option value="1" {{ old('status') ? (old('status') == '1' ? 'selected' : '') : ' ' }}>
                    Ativo</option>
                </select>
              </div>
            </div>

            <div class="d-flex w-100 justify-content-between mt-3">
              <button type="submit" class="btn btn-success ms-auto">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var el2 = document.getElementById('select-courses');
      if (el2) {
        new TomSelect(el2, {
          copyClassesToDropdown: false,
          dropdownParent: 'body',
          controlInput: '<input>',
          render: {
            item: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            },
            option: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            }
          }
        });
      }
      var el3 = document.getElementById('teachers');
      if (el3) {
        new TomSelect(el3, {
          copyClassesToDropdown: false,
          dropdownParent: 'body',
          controlInput: '<input>',
          render: {
            item: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            },
            option: function(data, escape) {
              return `<div>${escape(data.text)}</div>`;
            }
          }
        });
      }
    });
  </script>
@endsection
