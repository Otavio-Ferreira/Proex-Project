@extends('templates.template')

@section('styles')
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('forms.index') }}">Formulários</a>
          </div>
          <h2 class="page-title">
            Todos os Formulários
          </h2>
        </div>
        <div class="col-auto ms-auto">
          <a href="{{ route('forms.create') }}" class="btn btn-azure">
            Cadastrar
          </a>
          <a href="" class="btn btn-secondary">
            Relatórios
          </a>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="d-flex justify-content-end">
      <x-table.search route="{{ route('forms.index') }}" action="GET" value="{{ request('search') }}"
        placeholder="Pesquisar por fomulário" button="true"></x-table.search>
    </div>
    <div class="">
      <div class="card">
        <div class="card-body p-0">
          <table class="unded-3 w-100 table table-vcenter exclude table-hover card-table table-striped">
            <thead>
              <th>Título</th>
              <th>Prazo</th>
              <th>Respostas</th>
              <th>Status</th>
              <th width="5%"></th>
              <th width="5%"></th>
              <th width="5%"></th>
            </thead>
            <tbody>
              @foreach ($forms as $form)
                <tr>
                  <td>{{ $form->title }}</td>
                  <td>{{ date('d/m/Y', strtotime($form->date)) }}</td>
                  <td>
                    <x-badge.badge class="{{ $form->responses->count() == 0 ? 'bg-danger-lt' : ' bg-primary-lt' }}">
                      <x-slot:content>
                        {{ $form->responses->count() . '/' . $qtd_users }}
                      </x-slot:content>
                    </x-badge.badge>
                  </td>
                  <td>
                    <x-badge.badge class="{{ $form->status == 1 ? 'bg-success' : 'bg-danger' }}">
                      <x-slot:content>
                        {{ $form->status == 1 ? 'Ativo' : 'Inativo' }}
                      </x-slot:content>
                    </x-badge.badge>
                  </td>
                  <td><a class="btn p-1 px-2 rounded-2 btn-info btn-sm"
                      href="{{ route('forms.show', $form->id) }}">Detalhes</a>
                  </td>
                  <td><button class="btn p-1 px-2 rounded-2 btn-secondary btn-sm" type="button"
                      data-bs-toggle="offcanvas" data-bs-target="#forms-edit{{ $form->id }}"
                      aria-controls="offcanvasExample">Editar</button>
                  </td>
                  <td><a class="btn p-1 px-2 rounded-2 btn-yellow btn-sm"
                      href="{{ route('forms.reports', $form->id) }}">Relatórios</a>
                  </td>
                </tr>
                <div class="offcanvas offcanvas-end" tabindex="-1" id="forms-edit{{ $form->id }}"
                  aria-labelledby="offcanvasExampleLabel">
                  <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Editar formulario: {{ $form->title }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                  </div>
                  <div class="offcanvas-body">
                    <form action="{{ route('forms.update', $form->id) }}" method="post">
                      @csrf
                      @include('components.form-elements.input.input', [
                          'title' => 'Título do formulário',
                          'type' => 'text',
                          'class' => 'mb-3',
                          'name' => 'title',
                          'required' => 'true',
                          'placeholder' => 'Adicone um título para o formulário',
                          'value' => $form->title,
                      ])
                      @include('components.form-elements.input.input', [
                          'title' => 'Data de finalização',
                          'type' => 'date',
                          'class' => 'mb-3',
                          'name' => 'date',
                          'required' => 'true',
                          'placeholder' => 'Adicone a data de finalização',
                          'value' => $form->date,
                      ])
                      <x-form-elements.select.select title="Status" id="" name="status">
                        <x-slot:options>
                          <option value="" selected>Selecione</option>
                          <option value="1" {{ $form->status == 1 ? 'selected' : '' }}>Ativo</option>
                          <option value="0" {{ $form->status == 0 ? 'selected' : '' }}>Inativo</option>
                        </x-slot:options>
                      </x-form-elements.select.select>
                      <button type="submit" class="btn btn-primary">Salvar</button>
                    </form>
                  </div>
                </div>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="d-flex justify-content-center mt-5">
      {{ $forms->links() }}
    </div>
  </div>
@endsection
@section('scripts')
@endsection
