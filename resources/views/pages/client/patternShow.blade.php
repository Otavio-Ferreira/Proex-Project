@extends('templates.client')

@section('content')
  <div class="page-body">
    <div class="mb-4">
      <div class="mb-2">
        <p class="m-0 form-label" style="color: #333B69; font-size: 16px">{{ $info['title_one'] }}</p>
      </div>
      <div class="card rounded-3 border-0 p-2">
        <div class="table-responsive">
          <table class="table table-vcenter card-table table-borderless">
            <thead>
              <tr class="border-bottom">
                <th>Mês</th>
                <th>Previsto</th>
                <th>Realizado</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($data as $item)
                <tr>

                  @if ($info['type'] == 'evolucao')
                    <td>{{ isset($item['valor']) ? $item['mes'][0] : $item['mes'] }}</td>
                    <td>{{ number_format($item['esperado'], 2) }}%</td>
                    <td
                      class="{{ number_format($item['esperado'], 2) >= number_format($item['alcancado'], 2) ? 'text-danger' : 'text-success' }}">
                      +{{ number_format($item['alcancado'], 2) }}%
                    </td>
                    <td>{{ isset($item['valor']) ? number_format($item['valor'], 2) : number_format(0, 2) }}%</td>
                  @endif

                  @if ($info['type'] == 'orcamento')
                    <td>{{ $item['mes'] }}</td>
                    <td>{{ number_format($item['previsto'], 0, ',', '.') }}</td>
                    <td
                      class="{{ number_format($item['previsto'], 0, ',', '.') >= number_format($item['valor'], 0, ',', '.') ? 'text-danger' : 'text-success' }}">
                      {{ number_format($item['valor'], 0, ',', '.') }}
                    <td>{{ number_format($item['total'], 0, ',', '.') }}</td>
                    </td>
                  @endif

                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div>
      <div class="mb-2">
        <p class="m-0 form-label" style="color: #333B69; font-size: 16px">{{ $info['title_two'] }}</p>
      </div>
      <div id="chart-six" class="bg-white p-2 rounded-3 d-flex flex-wrap justify-content-center align-content-center"
        data-valores-custos-reais="{{ json_encode($detalhes) }}"></div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    var valores = JSON.parse(document.querySelector('#chart-six').getAttribute('data-valores-custos-reais'));

    var categoriasCustosReais = [];
    var dataCustosReais = [];

    for (var key in valores) {
      if (valores.hasOwnProperty(key)) {
        categoriasCustosReais.push(valores[key].nome);
        dataCustosReais.push(valores[key].valor);
      }
    }

    var options = {
      series: [{
        name: 'Valor',
        data: dataCustosReais
      }],
      chart: {
        height: 350,
        type: 'bar',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      colors: ["#83A5F5"],
      plotOptions: {
        bar: {
          borderRadius: 10,
          horizontal: true,
          barHeight: 35,
          dataLabels: {
            position: 'top', // top, center, bottom
          },
        }
      },
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val + '%';
        },
        offsetX: 35,
        style: {
          fontSize: '12px',
          colors: ["#304758"]
        }
      },
      xaxis: {
        categories: categoriasCustosReais,
        position: 'bottom',
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false
        },
        labels: {
          show: false,
        },
        crosshairs: {
          fill: {
            type: 'gradient',
            gradient: {
              colorFrom: '#D8E3F0',
              colorTo: '#BED1E6',
              stops: [0, 100],
              opacityFrom: 0.4,
              opacityTo: 0.5,
            }
          }
        }
      },
      grid: {
        show: false
      },
      yaxis: {
        categories: categoriasCustosReais,
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: true,
        }

      }
    };

    var chart = new ApexCharts(document.querySelector("#chart-six"), options);
    chart.render();
  </script>
@endsection
