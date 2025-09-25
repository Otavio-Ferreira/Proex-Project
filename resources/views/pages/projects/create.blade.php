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
          <a href="{{ route('projects.index') }}" class="btn btn-cyan">Voltar</a>
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

              @include('components.form-elements.input.input', [
                  'title' => 'Id da atividade',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'id_atividade',
                  'required' => 'true',
                  'placeholder' => 'Digite o id da atividade',
                  'value' => old('id_atividade') ?? $last->id_atividade+1,
              ])

              @include('components.form-elements.input.input', [
                  'title' => 'Id do projeto',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'id_projeto',
                  'required' => 'true',
                  'placeholder' => 'Digite o id do projeto',
                  'value' => old('id_projeto') ?? $last->id_projeto+1,
              ])

              <div class="mb-3">
                <label class="form-label required">Tipo</label>
                <select class="form-select" id="type" name="type" required>
                  <option value="">
                    Selecione
                  </option>
                  @foreach ($types as $type)
                    <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                      {{ $type->value }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label required">Modalidade</label>
                <select class="form-select" id="modality" name="modality" required>
                  <option value="">
                    Selecione
                  </option>
                  @foreach ($modalities as $modality)
                    <option value="{{ $modality->value }}" {{ old('modality') == $modality->value ? 'selected' : '' }}>
                      {{ $modality->value }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label required">Área temática</label>
                <select class="form-select" id="thematic_area" name="thematic_area" required>
                  <option value="">
                    Selecione
                  </option>
                  @foreach ($thematic_area as $area)
                    <option value="{{ $area->value }}" {{ old('thematic_area') == $area->value ? 'selected' : '' }}>
                      {{ $area->value }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-12 col-md-6">
              <div class="mb-3">
                <label class="form-label required">Coordenador</label>
                <select class="form-select" id="teachers" name="teacher">
                  <option value="">Selecione</option>
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

              @include('components.form-elements.input.input', [
                  'title' => 'Ano do projeto',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'year',
                  'placeholder' => 'Digite o ano do projeto',
                  'required' => 'true',
                  'value' => old('year') ?? '',
              ])

              <div class="mb-3">
                <label class="form-label required">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="" disabled selected>Selecione</option>
                  <option value="0" {{ old('status') ? (old('status') == '0' ? 'selected' : '') : ' ' }}>
                    Inativo</option>

                  <option value="1" {{ old('status') ? (old('status') == '1' ? 'selected' : '') : ' ' }}>
                    Ativo</option>

                  <option value="2" {{ old('status') ? (old('status') == '2' ? 'selected' : '') : ' ' }}>
                    Finalizado</option>
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label required">Curso/Departamento</label>
                <select class="form-select" id="select-courses" name="course" required>
                  <option value="">Selecione</option>
                  @foreach ($courses as $base_course)
                    <option value="{{ $base_course->id }}"
                      {{ old('course') ? (old('course') == $base_course->id ? 'selected' : '') : ' ' }}>
                      {{ $base_course->name }}</option>
                  @endforeach
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
