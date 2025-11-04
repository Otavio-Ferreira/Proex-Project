@extends('templates.template')

@section('styles')
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <style>
    #map {
      height: 300px;
      width: 100%;
    }
  </style>
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('projects.my') }}">Meus trabalhos</a> /
            <a href="{{ route('response.index', $response->id) }}">Relatório</a> /
            <a href="{{ route('response.session', [$response->id, 1]) }}">Sessão 1</a>
          </div>
          <h2 class="page-title">
            Sessão 1
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
            <li class="step-item {{ $key <= 1 ? 'cursor-pointer ' : '' }} {{ $key == 1 ? ' active cursor-pointer' : '' }}"
              {!! $key <= 1 ? 'onclick="show(' . $key . ')" ' : '' !!}>
              {{ $key }}ª Seção
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="col-12 col-md-10">
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step mb-3">
        <div class="card">
          <div class="card-body">
            <form action="{{ route('activitys.store', $response->id) }}" method="post">
              @csrf
              @include('components.form-elements.textarea.textarea', [
                  'title' => 'Descreva a atividade',
                  'type' => 'text',
                  'class' => 'mb-3',
                  'name' => 'activity',
                  'required' => 'true',
                  'placeholder' => 'Digite uma atividade',
              ])
              <div class="mb-3">
                <div class="d-flex justify-content-between">
                  <label class="form-label required">
                    Digite o local ou procure no mapa
                  </label>
                  <a class="text-decoration-none" onclick="chose()" href="#">
                    Não encontrou seu local?
                  </a>
                </div>
                <div class="gap-2" id="div-select-local">
                  <select class="form-select" id="select-local" id="address" name="address" required>
                    <option value="" selected>Pesquisar</option>
                  </select>
                </div>
                <div class="d-none" id="div-chose">
                  <input type="text" class="form-control" id="input-local" name="addressChose"
                    placeholder="Digite o nome do local">
                  <p class="text-red">
                    Selecione no mapa o local onde foi realizado.
                  </p>
                </div>
              </div>
              <div id="map"></div>
              <input type="hidden" name="latitude" id="latitude">
              <input type="hidden" name="longitude" id="longitude">
              <input type="hidden" name="place_id" id="place_id">
              <div class="d-flex justify-content-end mt-3">
                <button type="submit" class="btn btn-success">Adicionar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="border-top-0 border-end-0 border-bottom-0 border-4 border-primary card p-0 card-form-step "
        id="card-3">
        <div class="card-header">
          <h3 class="p-0 m-0">Detalhamento de atividades</h3>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            @if ($response->activitys->count() == 0)
              <div class="alert alert-yellow mt-3">
                Nenhuma atividade adicionada
              </div>
            @else
              <div class="card p-0 mt-3">
                <x-table.table tableClass="table-vcenter card-table table-striped">
                  <x-slot:ths>
                    <th>Atividade</th>
                    <th>Local</th>
                    <th width="5%"></th>
                  </x-slot:ths>
                  <x-slot:trs>
                    @foreach ($response->activitys as $activity)
                      <tr>
                        <td>{{ $activity->activity }}</td>
                        <td>{{ $activity->address }}</td>
                        <td>
                          <button class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#modal-delete-activity{{ $activity->id }}"><i
                              class="ti ti-trash"></i></button>

                          <x-modal.modal-alert route="{{ route('activitys.destroy', $activity->id) }}"
                            id="modal-delete-activity{{ $activity->id }}" class="modal-dialog-centered modal-sm"
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
            @if (isset($response))
              @if ($response->activitys->count() > 0)
                <a href="{{ route('forms.advance', [$response->id, 2]) }}" class="btn btn-outline-info ms-auto">
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
  <script src="{{ asset('assets/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const cearaViewbox = "-41.4,-2.7,-37.2,-7.8";
      var map = L.map('map').setView([-7.2287, -39.3126], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
      var marker;

      function updateMap(lat, lon) {
        const latlng = [lat, lon];
        map.setView(latlng, 13);
        if (marker) map.removeLayer(marker);
        marker = L.marker(latlng).addTo(map);
        document.getElementById("coordinates").innerText = `${lat}, ${lon}`;
      }

      // TomSelect
      const select = document.getElementById("select-local");
      const tom = new TomSelect(select, {
        valueField: "display_name",
        labelField: "display_name",
        searchField: "display_name",
        maxOptions: 10,
        loadThrottle: 500,
        preload: false,
        load: function(query, callback) {
          if (!query.length) return callback();
          fetch(
              `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&viewbox=${cearaViewbox}`
              )
            .then(res => res.json())
            .then(json => {
              json.forEach(item => item.display_name = resumirNome(item.display_name));
              callback(json);
            })
            .catch(() => callback());
        },
        onChange: function(value) {
          const selected = this.options[value];
          if (selected) {
            const lat = selected.lat;
            const lon = selected.lon;
            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lon;
            document.getElementById("place_id").value = selected.place_id;
            updateMap(lat, lon);
          }
        },
        render: {
          option: function(data, escape) {
            return `<div>${escape(data.display_name)}</div>`;
          },
          item: function(data, escape) {
            return `<div>${escape(data.display_name)}</div>`;
          }
        }
      });

      // Clique no mapa
      map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lon = e.latlng.lng;

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lon;

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
          .then(res => res.json())
          .then(data => {
            if (data && data.display_name) {
              const displayName = resumirNome(data.display_name); // menos resumido se quiser
              const placeId = data.place_id;

              // Adiciona a opção ao select
              tom.addOption({
                value: displayName, // o valor enviado no form
                display_name: displayName, // o que aparece no select
                lat: lat,
                lon: lon,
                place_id: placeId
              });

              // Atualiza os inputs hidden
              document.getElementById("place_id").value = placeId;
              document.getElementById("latitude").value = lat;
              document.getElementById("longitude").value = lon;

              tom.addItem(displayName);
            }
          });
      });

      // Reduz nome do local (remove país, CEP, etc.)
      function resumirNome(nomeCompleto) {
        let partes = nomeCompleto.split(',');
        if (partes.length > 3) {
          return partes.slice(0, 3).join(',').trim(); // ex: "Campus UFCA, Juazeiro do Norte, CE"
        }
        return nomeCompleto.trim();
      }
    });
  </script>
  <script>
    var set = 0

    function chose() {
      var div = document.getElementById('div-chose')
      var input = document.getElementById('input-local')
      var select = document.getElementById('div-select-local')

      if (set == 0) {
        div.classList.remove('d-none')
        select.classList.add('d-none')
        input.setAttribute('required', '')
        set = 1
      } else {
        div.classList.add('d-none')
        select.classList.remove('d-none')
        input.removeAttribute('required')
        input.value = null
        set = 0
      }
    }
  </script>
@endsection
