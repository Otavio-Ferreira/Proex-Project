@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('forms.index') }}">Formulários</a>/
            <a href="{{ route('forms.create') }}">Cadastrar Formulário</a>
          </div>
          <h2 class="page-title">
            Cadastro de Formulário
          </h2>
        </div>
        <div class="col-auto ms-auto">
          <a href="{{ route('forms.index') }}" class="btn btn-cyan">
            Voltar
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <form action="{{ route('forms.store') }}" method="post">
      <div class="row">
        <div class="col-12 col-md-8">
          <div class="card">
            <div class="card-body">
              <div class="">
                <div class="form-label required">Selecione para quais modalidades irá disponibilizar esse formulário</div>
                <div>
                  @foreach ($modalities as $modality)
                    <label class="form-check">
                      <input value="{{ $modality->value }}" name="modalities[]" class="form-check-input" type="checkbox">
                      <span class="form-check-label">{{ $modality->value }}</span>
                    </label>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-4">
          <div class="card">
            <div class="card-body">
              @csrf
              @include('components.form-elements.input.input', [
                  'title' => 'Título do formulário',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'title',
                  'required' => 'true',
                  'placeholder' => 'Adicone um título para o formulário',
                  'value' => old('title'),
              ])
              @include('components.form-elements.input.input', [
                  'title' => 'Prazo',
                  'type' => 'date',
                  'class' => 'mb-3',
                  'name' => 'date',
                  'required' => 'true',
                  'placeholder' => 'Adicone um prazo para responder',
                  'value' => old('date'),
              ])
              <x-form-elements.select.select title="Disponibilizar?" id="" name="status"
                class="mb-3">
                <x-slot:options>
                  <option value="">Selecione</option>
                  <option value="1" {{ old('status' == 1 ? 'selected' : '') }}>Sim</option>
                  <option value="0" {{ old('status' == 0 ? 'selected' : '') }}>Não</option>
                </x-slot:options>
              </x-form-elements.select.select>

              <div class="w-100 d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Salvar</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
@endsection
@section('scripts')
@endsection
