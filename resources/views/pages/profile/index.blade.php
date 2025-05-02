@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('profile.index') }}">Perfil</a>
          </div>
          <h2 class="page-title">
            Informações pessoais
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    <div class="col-12 col-md-8">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Informações complementares</div>

          <form action="{{ route('profile.store') }}" method="post">
            @csrf
            @include('components.form-elements.input.input', [
                'title' => 'Nome completo',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'coordinator_name',
                'required' => 'true',
                'placeholder' => 'Digite o nome do coordenador/tutor',
                'value' => isset($person->coordinator_name) ? $person->coordinator_name : '',
            ])

            <x-form-elements.select.select title="Perfil" id="" name="coordinator_profile">
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
                  <option value="{{ $base_course->name }}"
                    {{ isset($person->coordinator_course) ? ($person->coordinator_course == $base_course->name ? 'selected' : '') : '' }}>
                    {{ $base_course->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="d-flex w-100 justify-content-between mt-3">
              <button type="submit" class="btn btn-success ms-auto">Salvar alterações</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-12 col-md-4">
      <div class="card">
        <div class="card-body">
          <div class="card-title">Informações do usuário</div>
          <div class="mb-2">
            <i class="icon me-2 text-secondary icon-2 ti ti-id-badge-2"></i>
            Nome: <strong>{{ $user->name }}</strong>
          </div>
          <div class="mb-2">
            <i class="icon me-2 text-secondary icon-2 ti ti-mail"></i>
            Email: <strong>{{ $user->email }}</strong>
          </div>
          <div class="mb-2">
            <i class="icon me-2 text-secondary icon-2 ti ti-users-group"></i>
            Tipo de usuário: <strong>{{ $user->roles->first()->name }}</strong>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
@endsection
