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
            <a href="{{ route('response.session', [$response->id, 4]) }}">Sessão 4</a>
          </div>
          <h2 class="page-title">
            Sessão 4
          </h2>
        </div>
        <div class="col-auto ms-auto">
          <a href="{{ route('response.index', $response->id) }}" class="btn btn-cyan">Voltar</a>
          @if (($progress == 8 && $response->was_finished == 0) || $response->was_finished == 2)
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
              class="step-item {{ $key <= 4 ? 'cursor-pointer ' : '' }} {{ $key == 4 ? ' active cursor-pointer' : '' }}">
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">

      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step "
        id="card-6">
        <div class="card-header">
          <h3 class="p-0 m-0">Parcerias Internas</h3>
        </div>
        <div class="card-body">

          <form action="{{ route('internalPartners.store', $response->id) }}" method="post">
            @csrf
            <div class="mb-3">
              <label class="form-label">Título da ação parceira</label>
              <div class="d-flex gap-2">
                <select class="form-select" id="select-tags-partner" name="title_partner" required>
                  <option value="" selected>Selecione</option>
                  @foreach ($base_projects as $base_project)
                    <option value="{{ $base_project->id }}">
                      {{ $base_project->title }}</option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-success ms-auto">Adicionar</button>
              </div>
            </div>
          </form>

          <div class="table-responsive">
            @if ($response->internal_partners->count() == 0)
              <div class="alert alert-yellow mt-3">
                Nenhum parceiro adicionado
              </div>
            @else
              <div class="card p-0 mt-3">
                <x-table.table tableClass="table-vcenter card-table table-striped">
                  <x-slot:ths>
                    <th>Título da ação parceira</th>
                    <th width="5%"></th>
                  </x-slot:ths>
                  <x-slot:trs>
                    @foreach ($response->internal_partners as $internal_partner)
                      <tr>
                        <td>{{ $internal_partner->title_action_partner->title }}</td>
                        <td>
                          <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modal-delete-internal_partner{{ $internal_partner->id }}"><i
                              class="ti ti-trash"></i></button>

                          <x-modal.modal-alert route="{{ route('internalPartners.destroy', $internal_partner->id) }}"
                            id="modal-delete-internal_partner{{ $internal_partner->id }}"
                            class="modal-dialog-centered modal-sm" background="bg-danger" classBody="text-center py-4"
                            title="Excluír atividade" typeBtnClose="button" classBtnClose="me-auto w-100"
                            textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-danger w-100"
                            textBtnSave="Deletar">
                            <x-slot:content>
                              <i class="ti ti-alert-triangle icon icon-lg text-danger"></i>
                              <h3>Tem certeza?</h3>
                              <div class="text-secondary">
                                Você realmente deseja remover esse registro? Não será possível restaurá-lo depois!
                              </div>
                            </x-slot:content>
                          </x-modal.modal-alert>
                        </td>
                      </tr>
                    @endforeach
                  </x-slot:trs>
                </x-table.table>
              </div>
            @endif

            <div class="d-flex w-100 justify-content-between mt-3">
              <a href="{{ route('forms.return', [$response->id, 3]) }}" type="submit" class="btn btn-outline-info">
                <i class="icon ti ti-chevron-left"></i>
                Voltar</a>
              @if (isset($response))
                {{-- @if ($response->internal_partners->count() > 0) --}}
                  <a href="{{ route('forms.advance', [$response->id, 5]) }}" class="btn btn-info ms-auto">Avançar</a>
                {{-- @endif --}}
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
  <script>
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
