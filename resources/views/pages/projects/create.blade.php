@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('projects.index') }}">Trabalhos</a>
            <a href="{{ route('projects.create') }}">Adicionar</a>
          </div>
          <h2 class="page-title">
            Adicionar trabalho
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('profile.store') }}" method="post">
            @csrf
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
              <label class="form-label">Tipo</label>
              <select class="form-select" id="type" name="type">
                <option value="" selected disabled>Selecione</option>
                <option value="Programa" {{ old('type') ? (old('type') == 'Programa' ? 'selected' : '') : '' }}>
                  Programa</option>
                <option value="Projeto" {{ old('type') ? (old('type') == 'Projeto' ? 'selected' : '') : '' }}>
                  Projeto
                </option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Modalidade</label>
              <select class="form-select" id="modality" name="modality">
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

            {{-- <x-form-elements.select.select title="Perfil" id="" name="coordinator_profile">
              <x-slot:options>
                <option value="" selected disabled>Selecione</option>
                <option value="Docente"
                  {{ isset($person->coordinator_profile) ? ($person->coordinator_profile == 'Docente' ? 'selected' : '') : ' ' }}>
                  Docente</option>
                <option value="Técnico Administrativo"
                  {{ isset($person->coordinator_profile) ? ($person->coordinator_profile == 'Técnico Administrativo' ? 'selected' : '') : ' ' }}>
                  Técnico Administrativo</option>
                <option value="Discente"
                  {{ isset($person->coordinator_profile) ? ($person->coordinator_profile == 'Discente' ? 'selected' : '') : ' ' }}>
                  Discente</option>
              </x-slot:options>
            </x-form-elements.select.select>

            @include('components.form-elements.input.input', [
                'title' => 'SIAPE',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'coordinator_siape',
                'required' => 'true',
                'placeholder' => 'Digite o seu siape',
                'value' => isset($person->coordinator_siape) ? $person->coordinator_siape : '',
            ])

            <div class="mb-3">
              <label class="form-label">Curso</label>
              <select class="form-select" id="select-courses" name="coordinator_course" required>
                <option value="" selected disabled>Selecione</option>
                @foreach ($base_courses as $base_course)
                  <option value="{{ $base_course->id }}"
                    {{ isset($person->coordinator_course) ? ($person->coordinator_course == $base_course->name ? 'selected' : '') : '' }}>
                    {{ $base_course->name }}</option>
                @endforeach
              </select>
            </div> --}}

            <div class="d-flex w-100 justify-content-between mt-3">
              <button type="submit" class="btn btn-success ms-auto">Salvar alterações</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
@endsection
