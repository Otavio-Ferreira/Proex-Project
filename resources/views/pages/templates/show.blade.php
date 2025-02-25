@extends('templates.template')

@section('styles')
  <style>
    .customRange {
      width: 100%;
      height: 10px;
      background: linear-gradient(to right, #007bff 40%, #ddd 40%);
      border-radius: 5px;
      outline: none;
      transition: background 0.3s;

    }
  </style>
@endsection
@section('content')
  <div class="page-header d-print-none">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <ol class="breadcrumb breadcrumb-bar">
            <li class="breadcrumb-item">
              <a href="{{ route('templates.index') }}">Templates</a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('templates.show', $template->COD_TEMPLATES) }}">Detalhes</a>
            </li>
          </ol>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <a href="{{ route('templates.index') }}" class="btn btn-cyan"><i class="icon ti ti-arrow-left"></i>Voltar</a>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-steps">
              <i class="icon ti ti-plus"></i>
              Adicionar etapa
            </a>
            <x-modal.modal route="{{ route('steps.store') }}" id="modal-add-steps" class="modal-dialog-centered"
              title="Adicionar etapa ao template" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
              typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
              <x-slot:content>
                @if ($steps->sum('INCIDENCIA') < 100)
                  <input type="hidden" value="{{ $template->COD_TEMPLATES }}" name="cod_templates">
                  @include('components.form-elements.input.input', [
                      'title' => 'Nome da etapa',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'name',
                      'required' => 'true',
                      'placeholder' => 'Digite o nome da etapa',
                  ])
                  <div class="mb-3">
                    @include('components.form-elements.input.input', [
                        'title' =>
                            'Incidência disponível : ' . number_format($steps ? 100 - $steps->sum('INCIDENCIA') : '100') . '%',
                        'type' => 'number',
                        'class' => 'mb-3',
                        'name' => 'incidence',
                        'required' => 'true',
                        'step' => '00.01',
                        'min' => '0',
                        'max' => $steps ? 100 - $steps->sum('INCIDENCIA') : '100',
                        'placeholder' => 'Digite o valor da incidência (Ex: 12,19)',
                    ])
                  </div>
                @else
                  <div class="alert alert-danger">
                    Não é possível adicionar mais etapas pois as incidências ja ultrapassaram o limite
                    máximo de 100%
                  </div>
                @endif
              </x-slot:content>
            </x-modal.modal>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="card mb-3">
      <x-table.table tableClass="table-vcenter card-table table-striped">
        <x-slot:ths>
          <th>Nome do template</th>
          <th>Status</th>
          <th width="10px"></th>
          <th width="10px"></th>
        </x-slot:ths>
        <x-slot:trs>
          <tr>
            <td>{{ $template->NOME }}</td>
            <td>
              <x-badge.badge class="{{ $template->STATUS == 1 ? 'bg-success' : 'bg-danger' }}">
                <x-slot:content>
                  {{ $template->STATUS == 1 ? 'Ativo' : 'Inativo' }}
                </x-slot:content>
              </x-badge.badge>
            </td>
            <td>
              <a class="btn btn-secondary border-0" data-bs-toggle="modal"
                data-bs-target="#modal-edit-template{{ $template->COD_TEMPLATES }}"><i
                  class="ti ti-edit"></i></a>

              <x-modal.modal route="{{ route('templates.update', $template->COD_TEMPLATES) }}"
                id="modal-edit-template{{ $template->COD_TEMPLATES }}" class="modal-dialog-centered"
                title="Editar template" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
                typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                <x-slot:content>
                  @include('components.form-elements.input.input', [
                      'title' => 'Nome do template',
                      'type' => 'text',
                      'class' => 'mb-3',
                      'name' => 'name',
                      'required' => 'true',
                      'value' => $template->NOME,
                  ])

                  <x-form-elements.select.select title="Status" id="situacao" name="status">
                    <x-slot:options>
                      <option value="1" {{ $template->STATUS == 1 ? 'selected' : '' }}>Ativo
                      </option>
                      <option value="0" {{ $template->STATUS == 0 ? 'selected' : '' }}>Inativo
                      </option>
                    </x-slot:options>
                  </x-form-elements.select.select>
                </x-slot:content>
              </x-modal.modal>

            </td>
            <td>
              <button class="btn btn-danger" data-bs-toggle="modal"
                data-bs-target="#modal-delete{{ $template->COD_TEMPLATES }}"><i class="ti ti-trash"></i></button>

              <x-modal.modal-alert route="{{ route('templates.destroy', $template->COD_TEMPLATES) }}"
                id="modal-delete{{ $template->COD_TEMPLATES }}" class="modal-dialog-centered modal-sm"
                background="bg-danger" classBody="text-center py-4" title="Excluír template" typeBtnClose="button"
                classBtnClose="me-auto w-100" textBtnClose="Cancelar" typeBtnSave="submit" classBtnSave="btn-danger w-100"
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
        </x-slot:trs>
      </x-table.table>
    </div>
    <div class="">
      <div class="card">
        <x-table.table tableClass="table-vcenter card-table table-striped table-mobile-md">
          <x-slot:ths>
            <th>Ordem</th>
            <th>Nome</th>
            <th>Incidência</th>
            <th>Status</th>
            <th width="10%"></th>
          </x-slot:ths>
          <x-slot:trs>
            @foreach ($stepsList as $step)
              <tr>
                <td>{{ $step->ORDEM }}</td>
                <td>{{ $step->NOME }}</td>
                <td>{{ $step->INCIDENCIA }}%</td>
                <td>
                  <x-badge.badge class="{{ $step->STATUS == 1 ? 'bg-success' : 'bg-danger' }}">
                    <x-slot:content>
                      {{ $step->STATUS == 1 ? 'Ativo' : 'Inativo' }}
                    </x-slot:content>
                  </x-badge.badge>
                </td>
                <td>
                  <button class="btn" data-bs-toggle="modal"
                    data-bs-target="#modal-edit-step{{ $step->COD_ETAPAS_TEMPLATES }}">Editar</button>
                  <x-modal.modal route="{{ route('steps.update', $step->COD_ETAPAS_TEMPLATES) }}"
                    id="modal-edit-step{{ $step->COD_ETAPAS_TEMPLATES }}" class="modal-dialog-centered"
                    title="Editar etapa" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
                    typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
                    <x-slot:content>
                      <input type="hidden" value="{{ $step->COD_TEMPLATES }}" name="cod_templates">
                      <input type="hidden" value="{{ $step->COD_ETAPAS_TEMPLATES }}" name="cod_etapa_templates">
                      @include('components.form-elements.input.input', [
                          'title' => 'Nome da etapa',
                          'type' => 'text',
                          'name' => 'name',
                          'class' => 'mb-3',
                          'required' => 'true',
                          'value' => $step->NOME,
                      ])

                      <x-form-elements.select.select title="Status" id="status" name="status">
                        <x-slot:options>
                          <option value="1" {{ $step->STATUS == 1 ? 'selected' : '' }}>Ativo
                          </option>
                          <option value="0" {{ $step->STATUS == 0 ? 'selected' : '' }}>
                            Inativo</option>
                        </x-slot:options>
                      </x-form-elements.select.select>


                      @if ($step->STATUS == 0)
                        <div class="alert alert-danger">
                          Para alterar a incidência e a ordem é necessário que a etapa eteja ativa
                        </div>
                        <input type="hidden" name="incidence" value="{{ $step->INCIDENCIA }}">
                        <input type="hidden" name="order" value="{{ $step->ORDEM }}">
                      @else
                        <x-form-elements.select.select title="Ordem" id="order" name="order">
                          <x-slot:options>
                            @foreach ($stepsList as $stepOrder)
                              <option value="{{ $stepOrder->ORDEM }}"
                                {{ $stepOrder->ORDEM == $step->ORDEM ? 'selected' : '' }}>
                                {{ $stepOrder->ORDEM }}</option>
                            @endforeach
                          </x-slot:options>
                        </x-form-elements.select.select>
                        <div class="mb-3">
                          @include('components.form-elements.input.input', [
                              'title' =>
                                  'Incidência disponível : ' .
                                  number_format($steps ? 100 - $steps->sum('INCIDENCIA') : '100') .
                                  '%',
                              'type' => 'number',
                              'class' => 'mb-3',
                              'name' => 'incidence',
                              'required' => 'true',
                              'step' => '00.01',
                              'min' => '0',
                              'max' => $steps ? $step->INCIDENCIA + (100 - $steps->sum('INCIDENCIA')) : '0',
                              'placeholder' => 'Digite o valor da incidência (Ex: 12,19)',
                              'value' => $step->INCIDENCIA,
                          ])
                        </div>
                      @endif
                    </x-slot:content>
                  </x-modal.modal>
                </td>
              </tr>
            @endforeach
          </x-slot:trs>
        </x-table.table>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script></script>
@endsection
