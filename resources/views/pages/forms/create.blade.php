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
    <div class="card">
      <form action="{{ route('forms.store') }}" method="post">
        <div class="card-body row">
          @csrf
          @include('components.form-elements.input.input', [
              'title' => 'Título do formulário',
              'type' => 'text',
              'class' => 'col-12 col-md-12 col-lg-6',
              'name' => 'title',
              'required' => 'true',
              'placeholder' => 'Adicone um título para o formulário',
              'value' => old('title'),
          ])
          @include('components.form-elements.input.input', [
              'title' => 'Prazo',
              'type' => 'date',
              'class' => 'col-12 col-md-6 col-lg-3',
              'name' => 'date',
              'required' => 'true',
              'placeholder' => 'Adicone um prazo para responder',
              'value' => old('date'),
          ])
          <x-form-elements.select.select title="Disponibilizar?" id="" name="status" class="col-12 col-md-6 col-lg-3">
            <x-slot:options>
              <option value="" >Selecione</option>
              <option value="1" {{old('status' == 1 ? 'selected' : '')}}>Sim</option>
              <option value="0" {{old('status' == 0 ? 'selected' : '')}}>Não</option>
            </x-slot:options>
          </x-form-elements.select.select>

          <div class="w-100 d-flex justify-content-end">
              <button type="submit" class="btn btn-success">Salvar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
@section('scripts')
@endsection
