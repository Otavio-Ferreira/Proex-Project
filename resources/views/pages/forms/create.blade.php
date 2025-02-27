@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('forms.create') }}">Criar Formulário</a>
          </div>
          <h2 class="page-title">
            Criar Formulário
          </h2>
        </div>
        <div class="col-auto ms-auto">
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="">
      <div class="">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#add_form"
              aria-controls="offcanvasExample">
              Cadastrar formulário
            </button>
          </div>
          <div class="card-body">
            <table class="table table-vcenter table card-table table-vcenter text-nowrap datatable">
              <thead>
                <th>Título</th>
                <th>Data</th>
                <th>Status</th>
                <th width="10%"></th>
              </thead>
              <tbody>
                @foreach ($forms as $form)
                  <tr>
                    <td>{{ $form->title }}</td>
                    <td>{{ date('d/m/Y', strtotime($form->date)) }}</td>
                    <td>
                      <x-badge.badge class="{{ $form->status == 1 ? 'bg-success' : 'bg-danger' }}">
                        <x-slot:content>
                          {{ $form->status == 1 ? 'Ativo' : 'Inativo' }}
                        </x-slot:content>
                      </x-badge.badge>
                    </td>
                    <td><button class="btn btn-secondary" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#forms-edit{{ $form->id }}" aria-controls="offcanvasExample">Editar</button>
                    </td>
                  </tr>
                  <div class="offcanvas offcanvas-end" tabindex="-1" id="forms-edit{{ $form->id }}"
                    aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Editar formulario: {{ $form->title }}</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                      <form action="{{ route('forms.update', $form->id) }}" method="post">
                        @csrf
                        @include('components.form-elements.input.input', [
                            'title' => 'Título do formulário',
                            'type' => 'text',
                            'class' => 'mb-3',
                            'name' => 'title',
                            'required' => 'true',
                            'placeholder' => 'Adicone um título para o formulário',
                            'value' => $form->title
                        ])
                        @include('components.form-elements.input.input', [
                            'title' => 'Data de finalização',
                            'type' => 'date',
                            'class' => 'mb-3',
                            'name' => 'date',
                            'required' => 'true',
                            'placeholder' => 'Adicone a data de finalização',
                            'value' => $form->date
                        ])
                        <x-form-elements.select.select title="Status" id="" name="status">
                          <x-slot:options>
                            <option value="" selected>Selecione</option>
                            <option value="1" {{ $form->status == 1 ? 'selected' : '' }}>Ativo</option>
                            <option value="0" {{ $form->status == 0 ? 'selected' : '' }}>Inativo</option>
                          </x-slot:options>
                        </x-form-elements.select.select>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                      </form>
                    </div>
                  </div>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endsection


<div class="offcanvas offcanvas-end" tabindex="-1" id="add_form" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Cadastrar formulário</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{ route('forms.store') }}" method="post">
      @csrf
      @include('components.form-elements.input.input', [
          'title' => 'Título do formulário',
          'type' => 'text',
          'class' => 'mb-3',
          'name' => 'title',
          'required' => 'true',
          'placeholder' => 'Adicone um título para o formulário',
      ])
      @include('components.form-elements.input.input', [
          'title' => 'Data de finalização',
          'type' => 'date',
          'class' => 'mb-3',
          'name' => 'date',
          'required' => 'true',
          'placeholder' => 'Adicone a data de finalização',
      ])
      <x-form-elements.select.select title="Ativar?" id="" name="status">
        <x-slot:options>
          <option value="" selected>Selecione</option>
          <option value="1">Sim</option>
          <option value="0">Não</option>
        </x-slot:options>
      </x-form-elements.select.select>
      <button type="submit" class="btn btn-success">Enviar</button>
    </form>
  </div>
</div>
