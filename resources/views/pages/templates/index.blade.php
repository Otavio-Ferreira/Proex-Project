@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <ol class="breadcrumb breadcrumb-bar">
            <li class="breadcrumb-item">
              <a href="{{ route('templates.index') }}">Templates</a>
            </li>
          </ol>
        </div>
        <div class="col-auto ms-auto">
          <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
            data-bs-target="#modal-add-template">
            <i class="icon ti ti-plus"></i>
            Adicionar Template
          </a>
          <x-modal.modal route="{{ route('templates.store') }}" id="modal-add-template" class="modal-dialog-centered"
            title="Adicionar template" typeBtnClose="button" classBtnClose="me-auto" textBtnClose="Cancelar"
            typeBtnSave="submit" classBtnSave="btn-primary" textBtnSave="Salvar">
            <x-slot:content>
              @include('components.form-elements.input.input', [
                  'title' => 'Nome do template',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'name',
                  'required' => 'true',
                  'placeholder' => 'Digite um nome para o template',
              ])
              @if ($templates->count() > 0)
                <div class="mb-3">
                  <div class="form-label">Deseja criar um template a partir de outro?</div>
                  <div>
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="radios-inline" value="nao" checked
                        onchange="toggleTemplate('nao')">
                      <span class="form-check-label">Não</span>
                    </label>
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="radios-inline" value="sim"
                        onchange="toggleTemplate('sim')">
                      <span class="form-check-label">Sim</span>
                    </label>
                  </div>
                </div>
                <div id="div_select" class="d-none">
                  <label class="form-label" for="template">Escolha um template</label>
                  <select class="form-select" id="template" name="template">
                    <option value="" id="first_option" selected>Selecione</option>
                    @foreach ($templates as $template)
                      <option value="{{ $template->COD_TEMPLATES }}">
                        {{ $template->NOME }}</option>
                    @endforeach
                  </select>
                </div>
              @endif
            </x-slot:content>
          </x-modal.modal>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="card">
      <div class="table-responsive">
        <x-table.table tableClass="table-vcenter card-table table-striped">
          <x-slot:ths>
            <th>Nome do Template</th>
            <th>Status</th>
            <th width="10%"></th>
          </x-slot:ths>
          <x-slot:trs>
            @foreach ($templates as $template)
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
                  <a href="{{ route('templates.show', $template->COD_TEMPLATES) }}" class="btn">Detalhes</a>
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
  <script>
    function toggleTemplate(chose) {
      const templateSelect = document.getElementById('div_select');
      const selectElement = document.getElementById('template');

      if (chose === "sim") {
        templateSelect.classList.remove('d-none');
      }

      if (chose === "nao") {
        templateSelect.classList.add('d-none');
        selectElement.value = '';
      }
    }
  </script>
@endsection
