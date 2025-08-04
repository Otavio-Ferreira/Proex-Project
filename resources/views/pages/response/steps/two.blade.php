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
            <a href="{{ route('response.session', [$response->id, 2]) }}">Sessão 2</a>
          </div>
          <h2 class="page-title">
            Sessão 2
          </h2>
        </div>
        <div class="col-auto ms-auto">
          {{-- @if ($finished)
            @if ($response)
              @if (!$response->was_finished || $response->was_finished == 2)
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-finish-response"><i
                    class="icon ti ti-check"></i>Finalizar Formulário</button>

                <x-modal.modal-alert route="{{ route('forms.finish') }}" id="modal-finish-response"
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
            @endif
          @endif --}}
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
            <li class="step-item {{ $key <= 2 ? 'cursor-pointer ' : '' }} {{ $key == 2 ? ' active cursor-pointer' : '' }}"
              {!! $key <= 2 ? 'onclick="show(' . $key . ')" ' : '' !!}>
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0  card-form-step"
        id="card-4">
        <div class="card-header">
          <h3 class="p-0 m-0">Identificação e quantitativo do público beneficiado</h3>
        </div>
        <div class="card-body">
          <form action="{{ route('forms.persist', $response->id) }}" method="post">
            @csrf
            @include('components.form-elements.input.input', [
                'title' => 'Total do público interno à UFCA',
                'type' => 'number',
                'class' => 'mb-3',
                'name' => 'qtd_internal_audience',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
                'value' => isset($response->qtd_internal_audience) ? $response->qtd_internal_audience : '',
            ])
            @include('components.form-elements.input.input', [
                'title' => 'Total do público externo à UFCA',
                'type' => 'number',
                'class' => 'mb-3',
                'name' => 'qtd_external_audience',
                'required' => 'true',
                'placeholder' => 'Digite o seu nome',
                'value' => isset($response->qtd_external_audience) ? $response->qtd_external_audience : '',
            ])

            <div class="d-flex w-100 justify-content-between mt-3">
              <a href="{{ route('forms.return', [$response->id, 1]) }}" type="submit" class="btn btn-outline-info">
                <i class="icon ti ti-chevron-left"></i>
                Voltar</a>
              <button type="submit" class="btn btn-info ms-auto">Avançar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
@endsection
