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
            <a href="{{ route('response.session', [$response->id, 6]) }}">Sessão 6</a>
          </div>
          <h2 class="page-title">
            Sessão 6
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
              class="step-item {{ $key <= 6 ? 'cursor-pointer ' : '' }} {{ $key == 6 ? ' active cursor-pointer' : '' }}">
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step"
        id="card-8">
        <div class="card-header">
          <h3 class="p-0 m-0">Ações vinculadas ao programa de extensão</h3>
        </div>
        <div class="card-body">
          <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
            data-bs-target="#modal-add-extensionActions">
            <i class="icon ti ti-extensionActions-plus"></i>
            Adicionar ação
          </a>
          <x-modal.modal route="{{ route('extencionActions.store', $response->id) }}" id="modal-add-extensionActions"
            class="modal-dialog-centered" title="Adicionar ação" typeBtnClose="button" classBtnClose="me-auto"
            textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
            <x-slot:content>
              @include('components.form-elements.input.input', [
                  'title' => 'Ação que se articula ao programa de extensão',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'title_action',
                  'required' => 'true',
                  'placeholder' => 'Digite a ação',
              ])

              <x-form-elements.select.select title="A ação é voltada para escolas públicas? " id="role"
                name="its_for_public_schools">
                <x-slot:options>
                  <option value="" selected disabled>Selecione</option>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>
                </x-slot:options>
              </x-form-elements.select.select>
              @include('components.form-elements.textarea.textarea', [
                  'title' => 'A ação estabeleceu parceria internacional? Se sim, descreva',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'international_description',
                  'required' => 'false',
                  'placeholder' => 'Descrição',
              ])
            </x-slot:content>
          </x-modal.modal>

          <div class="table-responsive">
            @if ($response->extension_actions->count() == 0)
              <div class="alert alert-yellow mt-3">
                Nenhuma ação adicionada
              </div>
            @else
              <div class="card p-0 mt-3">
                <x-table.table tableClass="table-vcenter card-table table-striped">
                  <x-slot:ths>
                    <th>Ação</th>
                    <th>Escolas públicas?</th>
                    <th>Descrição internacional</th>
                    <th width="5%"></th>
                    <th width="5%"></th>
                  </x-slot:ths>
                  <x-slot:trs>
                    @foreach ($response->extension_actions as $extensionActions)
                      <tr>
                        <td>{{ $extensionActions->title_action }}</td>
                        <td>{{ $extensionActions->its_for_public_schools == 1 ? 'Sim' : 'Não' }}</td>
                        <td>{{ $extensionActions->international_description }}</td>
                        <td>
                          <button class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modal-edit-extensionActions{{ $extensionActions->id }}"><i
                              class="ti ti-edit"></i></button>
                          <x-modal.modal route="{{ route('extencionActions.update', $extensionActions->id) }}"
                            id="modal-edit-extensionActions{{ $extensionActions->id }}" class="modal-dialog-centered"
                            title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
                            typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                            <x-slot:content>
                              @include('components.form-elements.input.input', [
                                  'title' => 'Liste os títulos das Ações que se articulam ao Programa de Extensão',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'title_action',
                                  'required' => 'true',
                                  'value' => $extensionActions->title_action,
                              ])

                              <x-form-elements.select.select title="A Ação é voltada para escolas públicas? "
                                id="" name="its_for_public_schools">
                                <x-slot:options>
                                  <option value="1"
                                    {{ $extensionActions->its_for_public_schools == 1 ? 'selected' : '' }}>Sim
                                  </option>

                                  <option value="0"
                                    {{ $extensionActions->its_for_public_schools == 0 ? 'selected' : '' }}>Não
                                  </option>
                                </x-slot:options>
                              </x-form-elements.select.select>
                              @include('components.form-elements.textarea.textarea', [
                                  'title' => 'A Ação estabeleceu parceria internacional? Se sim, descreva',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'international_description',
                                  'required' => 'false',
                                  'value' => $extensionActions->international_description,
                              ])
                            </x-slot:content>
                          </x-modal.modal>
                        </td>
                        <td>
                          <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modal-delete-extensionActions{{ $extensionActions->id }}"><i
                              class="ti ti-trash"></i></button>

                          <x-modal.modal-alert route="{{ route('extencionActions.destroy', $extensionActions->id) }}"
                            id="modal-delete-extensionActions{{ $extensionActions->id }}"
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
          </div>

          <div class="d-flex w-100 justify-content-between mt-3">
            <a href="{{ route('forms.return', [$response->id, 5]) }}" type="submit" class="btn btn-outline-info">
              <i class="icon ti ti-chevron-left"></i>
              Voltar</a>
            @if (isset($response))
              @if ($response->extension_actions->count() > 0)
                <a href="{{ route('forms.advance', [$response->id, 7]) }}" class="btn btn-info ms-auto">Avançar</a>
              @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
@endsection
