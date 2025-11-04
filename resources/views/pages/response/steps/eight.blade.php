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
            <a href="{{ route('response.session', [$response->id, 8]) }}">Sessão 8</a>
          </div>
          <h2 class="page-title">
            Sessão 8
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
              class="step-item {{ $key <= 8 ? 'cursor-pointer ' : '' }} {{ $key == 8 ? ' active cursor-pointer' : '' }}">
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step"
        id="card-10">
        <div class="card-header">
          <h3 class="p-0 m-0">Redes sociais criadas para o programa/projeto</h3>
        </div>
        <div class="card-body">
          <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
            data-bs-target="#modal-add-socialMedia">
            Adicionar rede social
          </a>
          <x-modal.modal route="{{ route('socialMedia.store', $response->id) }}" id="modal-add-socialMedia"
            class="modal-dialog-centered" title="Adicionar rede social" typeBtnClose="button" classBtnClose="me-auto"
            textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
            <x-slot:content>
              @include('components.form-elements.input.input', [
                  'title' => 'Nome da rede social',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'name',
                  'required' => 'true',
                  'placeholder' => 'Digite o nome da rede social',
              ])
              @include('components.form-elements.input.input', [
                  'title' => 'Link da rede social',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'link',
                  'required' => 'true',
                  'placeholder' => 'Digite o link da rede social',
              ])
            </x-slot:content>
          </x-modal.modal>

          <div class="table-responsive">
            @if ($response->social_medias->count() == 0)
              <div class="alert alert-yellow mt-3">
                Nenhuma rede social adicionada
              </div>
            @else
              <div class="card p-0 mt-3">
                <x-table.table tableClass="table-vcenter card-table table-striped">
                  <x-slot:ths>
                    <th>Nome</th>
                    <th>Link</th>
                    <th width="5%"></th>
                    <th width="5%"></th>
                  </x-slot:ths>
                  <x-slot:trs>
                    @foreach ($response->social_medias as $socialMedia)
                      <tr>
                        <td>{{ $socialMedia->name }}</td>
                        <td>{{ $socialMedia->link }}</td>
                        <td>
                          <button class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modal-edit-socialMedia{{ $socialMedia->id }}"><i
                              class="ti ti-edit"></i></button>
                          <x-modal.modal route="{{ route('socialMedia.update', $socialMedia->id) }}"
                            id="modal-edit-socialMedia{{ $socialMedia->id }}" class="modal-dialog-centered"
                            title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
                            typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                            <x-slot:content>
                              @include('components.form-elements.input.input', [
                                  'title' => 'Nome da rede social',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'name',
                                  'required' => 'true',
                                  'value' => $socialMedia->name,
                                  'placeholder' => 'Digite o nome da rede social',
                              ])
                              @include('components.form-elements.input.input', [
                                  'title' => 'Link da rede social',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'link',
                                  'required' => 'true',
                                  'placeholder' => 'Digite o local',
                                  'value' => $socialMedia->link,
                                  'placeholder' => 'Digite o link da rede social',
                              ])
                            </x-slot:content>
                          </x-modal.modal>
                        </td>
                        <td>
                          <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modal-delete-socialMedia{{ $socialMedia->id }}"><i
                              class="ti ti-trash"></i></button>

                          <x-modal.modal-alert route="{{ route('socialMedia.destroy', $socialMedia->id) }}"
                            id="modal-delete-socialMedia{{ $socialMedia->id }}" class="modal-dialog-centered modal-sm"
                            background="bg-danger" classBody="text-center py-4" title="Excluír atividade"
                            typeBtnClose="button" classBtnClose="me-auto w-100" textBtnClose="Cancelar"
                            typeBtnSave="submit" classBtnSave="btn-danger w-100" textBtnSave="Deletar">
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
            <a href="{{ route('forms.return', [$response->id, 7]) }}" type="submit" class="btn btn-outline-info">
              <i class="icon ti ti-chevron-left"></i>
              Voltar</a>
            @if (isset($response))
              @if ($response->social_medias->count() > 0)
                <a href="{{ route('forms.advance', [$response->id, 9]) }}" class="btn btn-outline-info ms-2">
                  Avançar
                  <i class="icon ms-2 me-0 ti ti-chevron-right"></i></a>
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
