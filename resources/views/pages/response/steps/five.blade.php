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
            <a href="{{ route('response.session', [$response->id, 5]) }}">Sessão 5</a>
          </div>
          <h2 class="page-title">
            Sessão 5
          </h2><a href="{{ route('response.index', $response->id) }}" class="btn btn-cyan">Voltar</a>
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
        <div class="col-auto ms-auto">
          <a href="{{ route('response.index', $response->id) }}" class="btn btn-cyan">Voltar</a>
          @if (($progress == 10 && $response->was_finished == 0) || $response->was_finished == 2)
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
              class="step-item {{ $key <= 5 ? 'cursor-pointer ' : '' }} {{ $key == 5 ? ' active cursor-pointer' : '' }}">
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step"
        id="card-7">
        <div class="card-header">
          <h3 class="p-0 m-0">Parcerias externas</h3>
        </div>
        <div class="card-body">

          <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
            data-bs-target="#modal-add-externalPartner">
            <i class="icon ti ti-externalPartner-plus"></i>
            Adicionar parceiro
          </a>
          <x-modal.modal route="{{ route('externalPartners.store', $response->id) }}" id="modal-add-externalPartner"
            class="modal-dialog-centered" title="Adicionar parceiro externo" typeBtnClose="button" classBtnClose="me-auto"
            textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
            <x-slot:content>
              @include('components.form-elements.input.input', [
                  'title' => 'Nome do Parceiro',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'name_partner',
                  'required' => 'true',
                  'placeholder' => 'Digite o nome do parceiro',
              ])
              <x-form-elements.select.select title="Tipo de Instituição" id="institution_type" name="institution_type">
                <x-slot:options>
                  <option value="" selected disabled>Selecione</option>
                  <option value="Movimento Social Organizado (MSO)">Movimento Social Organizado (MSO)</option>
                  <option value="Privado (PR)">Privado (PR)</option>
                  <option value="Público Municipal (PM)">Público Municipal (PM)</option>
                  <option value="Público Estadual (PE)">Público Estadual (PE)</option>
                  <option value="Público Federal (PF)">Público Federal (PF)</option>
                </x-slot:options>
              </x-form-elements.select.select>
              <x-form-elements.select.select title="Tipo de Parceria" id="partnership_type" name="partnership_type">
                <x-slot:options>
                  <option value="" selected disabled>Selecione</option>
                  <option value="Cooperação (CP)">Cooperação (CP)</option>
                  <option value="Convênio (CV)">Convênio (CV)</option>
                  <option value="Contrato (CT)">Contrato (CT)</option>
                </x-slot:options>
              </x-form-elements.select.select>
            </x-slot:content>
          </x-modal.modal>

          <div class="table-responsive">
            @if ($response->external_partners->count() == 0)
              <div class="alert alert-yellow mt-3">
                Nenhum parceiro adicionado
              </div>
            @else
              <div class="card p-0 mt-3">
                <x-table.table tableClass="table-vcenter card-table table-striped">
                  <x-slot:ths>
                    <th>Nome do parceiro</th>
                    <th>Tipo de instituição</th>
                    <th>Tipo de parceria</th>
                    <th width="5%"></th>
                    <th width="5%"></th>
                  </x-slot:ths>
                  <x-slot:trs>
                    @foreach ($response->external_partners as $externalPartner)
                      <tr>
                        <td>{{ $externalPartner->name_partner }}</td>
                        <td>{{ $externalPartner->institution_type }}</td>
                        <td>{{ $externalPartner->partnership_type }}</td>
                        <td>
                          <button class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#modal-edit-externalPartner{{ $externalPartner->id }}"><i
                              class="ti ti-edit"></i></button>
                          <x-modal.modal route="{{ route('externalPartners.update', $externalPartner->id) }}"
                            id="modal-edit-externalPartner{{ $externalPartner->id }}" class="modal-dialog-centered"
                            title="Editar atividade" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
                            typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                            <x-slot:content>
                              @include('components.form-elements.input.input', [
                                  'title' => 'Nome do Parceiro',
                                  'type' => 'text',
                                  'class' => 'mb-3',
                                  'name' => 'name_partner',
                                  'required' => 'true',
                                  'placeholder' => 'Digite o nome do parceiro',
                                  'value' => $externalPartner->name_partner,
                              ])
                              <x-form-elements.select.select title="Tipo de Instituição" id=""
                                name="institution_type">
                                <x-slot:options>
                                  <option value="" selected>Selecione</option>
                                  <option value="Movimento Social Organizado (MSO)"
                                    {{ $externalPartner->institution_type == 'Movimento Social Organizado (MSO)' ? 'selected' : '' }}>
                                    Movimento Social Organizado (MSO)</option>
                                  <option value="Privado (PR)"
                                    {{ $externalPartner->institution_type == 'Privado (PR)' ? 'selected' : '' }}>
                                    Privado (PR)</option>
                                  <option value="Público Municipal (PM)"
                                    {{ $externalPartner->institution_type == 'Público Municipal (PM)' ? 'selected' : '' }}>
                                    Público Municipal (PM)</option>
                                  <option value="Público Estadual (PE)"
                                    {{ $externalPartner->institution_type == 'Público Estadual (PE' ? 'selected' : '' }}>
                                    Público Estadual (PE)</option>
                                  <option value="Público Federal (PF)"
                                    {{ $externalPartner->institution_type == 'Público Federal (PF)' ? 'selected' : '' }}>
                                    Público Federal (PF)</option>
                                </x-slot:options>
                              </x-form-elements.select.select>
                              <x-form-elements.select.select title="Tipo de Parceria" id="role"
                                name="partnership_type">
                                <x-slot:options>
                                  <option value="" selected>Selecione</option>
                                  <option value="Cooperação (CP)"
                                    {{ $externalPartner->partnership_type == 'Cooperação (CP)' ? 'selected' : '' }}>
                                    Cooperação (CP)</option>
                                  <option value="Convênio (CV)"
                                    {{ $externalPartner->partnership_type == 'Convênio (CV)' ? 'selected' : '' }}>
                                    Convênio (CV)</option>
                                  <option value="Contrato (CT)"
                                    {{ $externalPartner->partnership_type == 'Contrato (CT)' ? 'selected' : '' }}>
                                    Contrato (CT)</option>
                                </x-slot:options>
                              </x-form-elements.select.select>
                            </x-slot:content>
                          </x-modal.modal>
                        </td>
                        <td>
                          <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modal-delete-externalPartner{{ $externalPartner->id }}"><i
                              class="ti ti-trash"></i></button>

                          <x-modal.modal-alert route="{{ route('externalPartners.destroy', $externalPartner->id) }}"
                            id="modal-delete-externalPartner{{ $externalPartner->id }}"
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
            <a href="{{ route('forms.return', [$response->id, 4]) }}" type="submit" class="btn btn-outline-info">
              <i class="icon ti ti-chevron-left"></i>
              Voltar</a>
            @if (isset($response))
              @if ($response->external_partners->count() > 0)
                <a href="{{ route('forms.advance', [$response->id, 6]) }}" class="btn btn-info ms-auto">Avançar</a>
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
