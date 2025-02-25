@extends('templates.client')

@section('styles')
  <style>
    .active {
      color: #1814F3 !important;
      background: none !important;
      border-bottom: solid 3px #1814F3 !important;
      border-radius: 0px !important;
    }

    .show {
      border-bottom: none !important;
    }
  </style>
@endsection
@section('content')
  <div class="page-body">
    @csrf
    <div class="w-100 text-end text-blue">
      <div class="bg-white px-3 p-2 rounded-3 text-start">
        <label for="" class="fw-bold">Filtros</label> <br>
        @foreach ($all as $input)
          <label class="form-check form-check-inline mt-2">
            <input class="form-check-input border-blue" type="checkbox"
              onchange="show_hide(this, '{{ str_replace([' ', '-'], '_', strtolower($input)) }}')">
            <span class="form-check-label">{{ ucfirst($input) }}</span>
          </label>
        @endforeach
      </div>
    </div>
    <ul class="nav nav-pills mb-3 border-bottom d-flex flex-nowrap overflow-x-auto" id="pills-tab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-tudo-tab" data-bs-toggle="pill" data-bs-target="#pills-tudo"
          type="button" role="tab" aria-controls="pills-tudo" aria-selected="true">Tudo</button>
      </li>
      @foreach ($data as $nav)
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="pills-{{ str_replace(' ', '_', $nav->NOME) }}-tab" data-bs-toggle="pill"
            data-bs-target="#pills-{{ str_replace(' ', '_', $nav->NOME) }}" type="button" role="tab"
            aria-controls="pills-{{ str_replace(' ', '_', $nav->NOME) }}"
            aria-selected="true">{{ ucfirst($nav->NOME) }}</button>
        </li>
      @endforeach
    </ul>
    <div class="tab-content" id="pills-tabContent">
      @if ($data->count() > 0)
        <div class="tab-pane fade active show"
          id="pills-tudo" role="tabpanel"
          aria-labelledby="pills-tudo-tab" tabindex="0">
          <div
            class="bg-white rounded-3 p-3 d-flex flex-wrap justify-content-between aling-items-center aling-content-center mb-3">
            <p class="m-0 text-dark">Total</p>
            <p class="m-0 text-danger">R$ {{ number_format($tudo->sum('VALOR'), 2, ',', '.') }}</p>
          </div>
          @if ($tudo->count() > 0)
            <div class="bg-white rounded-3 p-2">
              @foreach ($tudo as $item)
                <div class="p-1 categoria {{ str_replace([' ', '-'], '_', strtolower($item->CATEGORIA_DESPESAS)) }}">
                  <div class="card-body d-flex flex-wrap justify-content-between align-content-center align-items-center">
                    <div class="d-flex py-1 align-items-center">
                      <span class="bg-blue-lt p-1 ps-2 pe-2 rounded me-3 ms-1">
                        <i class="ti ti-premium-rights fs-1"></i>
                      </span>
                      <div class="flex-fill">
                        <div class="fw-bold text-dark">{{ $item->CATEGORIA_DESPESAS }}</div>
                        <div class="text-secondary fw-light fs-5">
                          {{ \Carbon\Carbon::parse($item->DATA_PAGAMENTO)->locale('pt_BR')->translatedFormat('d M Y') }}
                        </div>
                      </div>
                    </div>
                    <div class="align-items-center text-danger">
                      - R$ {{ number_format($item->VALOR, 2, ',', '.') }}
                    </div>
                  </div>
                </div>
                <hr class="m-0">
              @endforeach
            </div>
          @else
            <div class="alert alert-danger">
              Nenhum resultado encontrado!
            </div>
          @endif
        </div>
        @foreach ($data as $tab)
          <div class="tab-pane fade"
            id="pills-{{ str_replace(' ', '_', $tab->NOME) }}" role="tabpanel"
            aria-labelledby="pills-{{ str_replace(' ', '_', $tab->NOME) }}-tab" tabindex="0">
            <div
              class="bg-white rounded-3 p-3 d-flex flex-wrap justify-content-between aling-items-center aling-content-center mb-3">
              <p class="m-0 text-dark">Total</p>
              <p class="m-0 text-danger">R$ {{ number_format($tab->costs->sum('VALOR'), 2, ',', '.') }}</p>
            </div>
            @if ($tab->costs->count() > 0)
              <div class="bg-white rounded-3 p-2">
                @foreach ($tab->costs as $item)
                  <div class="p-1 categoria {{ str_replace([' ', '-'], '_', strtolower($item->CATEGORIA_DESPESAS)) }}">
                    <div
                      class="card-body d-flex flex-wrap justify-content-between align-content-center align-items-center">
                      <div class="d-flex py-1 align-items-center">
                        <span class="bg-blue-lt p-1 ps-2 pe-2 rounded me-3 ms-1">
                          <i class="ti ti-premium-rights fs-1"></i>
                        </span>
                        <div class="flex-fill">
                          <div class="fw-bold text-dark">{{ $item->CATEGORIA_DESPESAS }}</div>
                          <div class="text-secondary fw-light fs-5">
                            {{ \Carbon\Carbon::parse($item->DATA_PAGAMENTO)->locale('pt_BR')->translatedFormat('d M Y') }}
                          </div>
                        </div>
                      </div>
                      <div class="align-items-center text-danger">
                        - R$ {{ number_format($item->VALOR, 2, ',', '.') }}
                      </div>
                    </div>
                  </div>
                  <hr class="m-0">
                @endforeach
              </div>
            @else
              <div class="alert alert-danger">
                Nenhum resultado encontrado!
              </div>
            @endif
          </div>
        @endforeach
      @else
        <div class="alert alert-danger">
          Nenhum resultado encontrado!
        </div>
      @endif
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    function show_hide(checkbox, className) {
      // Primeiro, esconde todas as divs de categorias
      document.querySelectorAll('.categoria').forEach(function(element) {
        element.classList.add('d-none');
      });

      // Seleciona todos os checkboxes que estão marcados
      var checkedBoxes = document.querySelectorAll('input[type="checkbox"]:checked');

      // Mostra apenas as divs das categorias dos checkboxes que estão marcados
      checkedBoxes.forEach(function(checked) {
        var className = checked.getAttribute('onchange').match(/'([^']+)'/)[1];
        document.querySelectorAll('.' + className).forEach(function(element) {
          element.classList.remove('d-none');
        });
      });

      // Se nenhum checkbox estiver marcado, mostra todas as divs de volta
      if (checkedBoxes.length === 0) {
        document.querySelectorAll('.categoria').forEach(function(element) {
          element.classList.remove('d-none');
        });
      }
    }
  </script>
@endsection
