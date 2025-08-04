@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('projects.my') }}">Meus trabalhos</a> /
            <a href="{{ route('response.index', $response->id) }}">Relatório</a> /
            <a href="{{ route('response.session', [$response->id, 7]) }}">Sessão 7</a>
          </div>
          <h2 class="page-title">
            Sessão 7
          </h2>
        </div>
        <div class="col-auto ms-auto">
          <a href="{{ route('response.index', $response->id) }}" class="btn btn-cyan">Voltar</a>
          @if (($progress == 10 && $response->was_finished == 0) || $response->was_finished == 2)
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-finish-response"><i
                class="icon ti ti-check"></i>Finalizar Formulário</button>

            <x-modal.modal-alert route="{{ route('forms.finish', $response->id) }}" id="modal-finish-response"
              class="modal-dialog-centered modal-sm" background="bg-success" classBody="text-center py-4"
              title="Finalizar formulário" typeBtnClose="button" classBtnClose="me-auto w-100" textBtnClose="Cancelar"
              typeBtnSave="submit" classBtnSave="btn-success w-100" textBtnSave="Finalizar">
              <x-slot:content>
                <i class="ti ti-alert-triangle icon icon-lg text-success"></i>
                <h3>Tem certeza?</h3>
                <div class="text-secondary">
                  Você realmente deseja finalizar o formulário? Não será possível modificá-lo depois!
                </div>
              </x-slot:content>
            </x-modal.modal-alert>
          @endif
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    @if ($form)
      @if (isset($response) && $response->was_finished == 2 && isset($response->comment->comment))
        <div class="alert alert-danger mb-1">
          <h4>Observações:</h4>
          {{ $response->comment->comment }}
        </div>
      @endif
    @endif

    <div class="card col-12 col-md-12 col-lg-2 d-none d-lg-block">
      <div class="card-body">
        <ul class="steps steps-counter steps-vertical">
          @foreach ($steps as $key => $step)
            <li
              class="step-item {{ $key <= 7 ? 'cursor-pointer ' : '' }} {{ $key == 7 ? ' active cursor-pointer' : '' }}">
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step"
        id="card-9">
        <div class="card-header">
          <h3 class="p-0 m-0">Desenvolvimento de tecnologia social</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('forms.persist', $response->id) }}" method="post">
            @csrf
            @include('components.form-elements.textarea.textarea', [
                'title' => 'A ação atuou com o desenvolvimento de alguma tecnologia social? Se sim, descreva',
                'type' => 'text',
                'class' => 'mb-3',
                'name' => 'social_technology_development',
                'required' => 'true',
                'value' => isset($response->social_technology_development)
                    ? $response->social_technology_development
                    : '',
            ])

            <div class="d-flex w-100 justify-content-between mt-3">
              <a href="{{ route('forms.return', [$response->id, 6]) }}" type="submit" class="btn btn-outline-info">
                <i class="icon ti ti-chevron-left"></i>
                Voltar</a>
              @if (isset($response->social_technology_development))
                <a href="{{ route('forms.advance', [$response->id, 8]) }}" class="btn btn-info ms-auto">Avançar</a>
              @else
                <button type="submit" class="btn btn-info ms-auto">Avançar</button>
              @endif
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
    function show(id) {
      let divs = document.getElementsByClassName('card-form-step');

      for (let el of divs) {
        el.classList.add('d-none');
      }
      let div = document.getElementById(`card-${id}`);
      if (div) {
        div.classList.remove('d-none');
      }
    }
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var el = document.getElementById('select-tags');
      if (el) {
        new TomSelect(el, {
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
    });
    document.addEventListener("DOMContentLoaded", function() {
      var el2 = document.getElementById('select-tags-partner');
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
    });
  </script>
@endsection
