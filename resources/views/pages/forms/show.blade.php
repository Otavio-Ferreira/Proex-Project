@extends('templates.template')

@section('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/styleDataTable.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/kanban/kanbanIdeas.css') }}">

  <style>
    .iconCamera {
      color: #000000b5;
    }

    .iconCamera:hover {
      color: #2e2d2d9a;
    }

    .circle {
      width: 50px;
      height: 50px;
      border: 1px solid #828282;
      border-radius: 50%;
      background-color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      position: absolute;
      bottom: -5%;
      left: 50%;
      transform: translate(-50%, -50%);
      cursor: pointer;
    }

    #table thead th {
      white-space: nowrap;
      /* Evita que o cabeçalho seja quebrado */
      width: auto;
      /* Permite que a largura seja determinada pelo conteúdo */
    }

    #table tbody td {
      white-space: nowrap;
      /* Evita quebra de texto nas células */
    }

    #table {
      table-layout: fixed;
      /* Garante que as colunas do thead e tbody tenham a mesma largura */
      width: 100%;
    }
  </style>
  <style>
    .circleGraph {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      background: conic-gradient(#4caf50 0% 0%,
          /* Inicial */
          #ccc 0% 100%);
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .inner-circle {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .progress-value {
      font-size: 10px;
      font-weight: bold;
    }
  </style>
@endsection
@section('content')
  <div class="page-header">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col-12 col-md">
          <div class="page-pretitle">
            <a href="{{ route('forms.create') }}">Formulários</a> /
            <a href="{{ route('forms.show', $form->id) }}">Detalhes</a>
          </div>
          <h2 class="page-title">
            Detalhes
          </h2>
        </div>
        <div class="d-flex align-items-center col-sm-12 col-md-auto">
          <div class="input-icon me-2">
            <input type="text" value="" id="customFilter" class="form-control" placeholder="Pesquisar ...">
            <span class="input-icon-addon">
              <i class="ti icon text-primary ti-search"></i>
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body">
    <div class="container-fluid d-flex gap-3 w-100" style="height: calc(100vh - 115px); overflow-x:auto;">
      @foreach ($columns as $index => $column)
        <x-kanban.column id="kanbanVisitantes{{ $index }}" classTbody="ideas" type="table"
          title="{{ $column['TITULO'] }}" recallColumn="false" dataColumn="kanbanVisitantes{{ $index }}"
          badgeQtd="{{ count($column['DATA']) }}" colors="{{ $column['COR'] }}" bgColor="{{ $column['COR'] }}-lt"
          widthCol="260px">

          @foreach ($column['DATA'] as $key => $item)
            <tr>
              <td class="p-0">
                <a href="{{ route('response.edit', $item['RESPONSE']->id) }}"
                  class="text-decoration-none card alert border-0 alert-{{ $column['COR'] }} p-2">
                  <div class="row">
                    <div class="col-8">
                      {{-- <p class="m-0 fs-3 text-dark">{{ $item['RESPONSE']->user->name }}</p> --}}
                      <p class="m-0 text-muted">
                        {{ \Illuminate\Support\Str::limit($item['RESPONSE']->action->title, 45, '...') }}</p>
                    </div>
                    <div class="col-4">
                      <div class="circleGraph" data-value="{{ $item['PROGRESS'] }}">
                        <div class="inner-circle">
                          <span class="progress-value"></span>%
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr class="m-0 my-1">
                  <div>
                    <div class="d-flex mb-1">
                      <span class="badge bg-blue-lt w-100">
                        {{ $item['RESPONSE']->user->name }}
                        {{-- R$ {{ number_format($soma, 2, ',', '.') }} /
                        R$ {{ number_format($item->CARTEIRA, 2, ',', '.') }} --}}
                      </span>
                    </div>
                    <span class="badge bg-dark-lt w-100">
                      <i class="icon fs-4 ti ti-calendar"></i>
                      {{ date('d/m/Y H:i:s', strtotime($item['RESPONSE']->created_at)) }}
                    </span>
                  </div>
                </a>
              </td>
            </tr>
          @endforeach
        </x-kanban.column>
      @endforeach
    </div>
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/kanban/dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/js/kanban/startDataTable.js') }}"></script>
  <script src="{{ asset('assets/js/kanban/kanbanColumn.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
  <script>
    $(document).ready(function() {
      var table = $('#myTable').DataTable({
        info: false,
        ordering: false,
        paging: true,
        searching: true,
        autoWidth: false,
        scrollCollapse: false,
        border: false,
        lengthChange: false, // Remove o seletor de quantidade de registros
        pagingType: 'simple_numbers', // Exemplo de tipo de paginação, pode ser customizado
        language: {
          zeroRecords: " ",
          emptyTable: " ",
          paginate: {
            first: "Primeiro",
            last: "Último",
            next: "Próximo",
            previous: "Anterior"
          }
        }
      });

      $('#customFilter').on('keyup', function() {
        table.search(this.value).draw();
      });

      $('.customFilter').on('keyup', function() {
        table.search(this.value).draw();
      });
    });
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const circles = document.querySelectorAll('.circleGraph');

      circles.forEach(function(circle) {
        let value = parseInt(circle.getAttribute('data-value')) || 0;
        let maxValue = 12; // Defina o valor máximo
        let percentage = (value / maxValue) * 100; // Converte para percentual

        // Aplica o progresso ao estilo de background
        circle.style.background = `conic-gradient(#066FD1 ${percentage}%, #ccc ${percentage}% 100%)`;

        // Atualiza o valor de progresso dentro do círculo, se existir
        let progressText = circle.querySelector('.progress-value');
        if (progressText) {
          progressText.textContent = percentage.toFixed(0).replace('.', ',');
        }
      });
    });
  </script>
@endsection
