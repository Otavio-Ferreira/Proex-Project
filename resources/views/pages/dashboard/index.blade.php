@extends('templates.template')

@section('styles')
  <style>
    * {
      margin: 0;
      padding: 0;
    }

    #chart-container {
      position: relative;
      height: 300px;
      width: 100%;
    }

    #chart-container2 {
      position: relative;
      height: 300px;
      width: 100%;
    }

    #chart-container3 {
      height: 500px;
      position: relative;
    }

    #chart-container4 {
      height: 300px;
      position: relative;
    }
  </style>
@endsection
@section('content')
  <div class="page-header">
    <div class="">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            <a href="{{ route('dashboard.index') }}">Dashboard</a>
          </div>
          <h2 class="page-title">
            Dashboard
          </h2>
        </div>
        <div class="col-auto ms-auto">
          <form action="{{ route('dashboard.index') }}" method="GET">
            @csrf
            <div class="d-flex">
              <select class="form-select me-1" id="" name="form" required>
                <option value="" selected disabled>Selecione um ano</option>
                @foreach ($forms as $year)
                  <option value="{{ $year->id }}" {{ old('year') == $year->id ? 'selected' : '' }}>
                    {{ date('Y', strtotime($year->date)) }}</option>
                @endforeach
                <option value="">Tudo</option>
              </select>
              <button class="btn btn-primary">Filtrar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="page-body row">
    @can('ver_dashboard')
      <div class="col-12 col-md-6">
        <div class="row">
          @foreach ($cards_alcance as $item)
            <div class="col-6">
              <div class="alert alert-primary card-body">
                <div class="pt-3 pb-3">
                  <div class="subheader">Total de pessoas</div>
                  <div class="d-flex align-items-baseline">
                    <div class="h1 mb-0 me-2">{{ number_format($item['value'], 0, ',', '.') }}</div>
                    <div class="me-auto">
                    </div>
                  </div>
                  <div class="text-secondary mt-2">{{ $item['title'] }}</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="col-12 col-md-6">
        <div class="row row-cards">
          @foreach ($cards_projeto as $item)
            <div class="col-sm-6 col-lg-6">
              <div class="card card-sm">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-auto">
                      <div class="bg-{{ $item['color'] }} text-white avatar">
                        <i class="icon ti {{ $item['icon'] }} "></i>
                      </div>
                    </div>
                    <div class="col">
                      <div class="font-weight-medium">{{ $item['title'] }}</div>
                      <div class="text-secondary">{{ $item['value'] }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="col-12 col-lg-4 row">
        <h3 class="text-muted mb-2">Quantidade de projetos por tipo de ações</h3>
        <div class="col-6">
          <div id="chart-container" class="w-100 card" data-value='@json($cards_acao[0]['cards'])'></div>
        </div>
        <div class="col-6">
          <div id="chart-container2" class="w-100 card" data-value='@json($cards_acao[1]['cards'])'></div>
        </div>
      </div>

      <div class="col-12 col-lg-8 p-0">
        <h3 class="text-muted mb-2">Ranking de projetos da UFCA por ano</h3>
        <div id="chart-container4" class="w-100 card" data-value='{{ $ranking_projects }}'></div>
      </div>

      <div class="col-12 mt-2">
        <h3 class="text-muted mb-2">Ranking de projetos por cursos</h3>
        <div class="">
          <div id="chart-container3" class="w-100 card" data-value='{{ $ranking_course }}'></div>
        </div>
        {{-- <div class="col-6">
          <div id="chart-container4" class="w-100 card" data-value='{{ $ranking_projects }}'></div>
        </div> --}}
      </div>

      <div class="col-12 mt-2">
        <h3 class="text-muted mb-2">Mapa de projetos do Ceará</h3>
        <div id="mapa-ceara" class="card" style="width: 100%; height: 800px;"></div>
      </div>
    @endcan
  </div>
@endsection
@section('scripts')
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script>
    var dom = document.getElementById('chart-container');
    var chartData = JSON.parse(dom.getAttribute('data-value')); // ← pegando os dados

    // Converte para o formato aceito pelo ECharts
    var pieData = chartData.map(item => ({
      value: item.value,
      name: item.title
    }));

    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });

    var option = {
      tooltip: {
        trigger: 'item'
      },
      legend: {
        top: '5%',
        center: 'center'
      },
      series: [{
        name: 'Tipo de Ação',
        type: 'pie',
        radius: ['40%', '70%'],
        center: ['50%', '60%'],
        startAngle: 180,
        endAngle: 360,
        data: pieData,
        width: '100%', // Ajusta automaticamente ao tamanho da div
        height: '100%',
        label: {
          show: true,
          position: 'inside', // ou 'outside' se preferir fora da barra
          formatter: '{c}' // mostra apenas o valor (ex: 23)
        },
      }]
    };

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
  </script>
  <script>
    var dom = document.getElementById('chart-container2');
    var chartData = JSON.parse(dom.getAttribute('data-value')); // ← pegando os dados

    // Converte para o formato aceito pelo ECharts
    var pieData = chartData.map(item => ({
      value: item.value,
      name: item.title
    }));

    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });

    var option = {
      tooltip: {
        trigger: 'item'
      },
      legend: {
        top: '5%',
        center: 'center'
      },
      series: [{
        name: 'Tipo de Ação',
        type: 'pie',
        radius: ['40%', '70%'],
        center: ['50%', '60%'],
        startAngle: 180,
        endAngle: 360,
        data: pieData,
        label: {
          show: true,
          position: 'inside', // ou 'outside' se preferir fora da barra
          formatter: '{c}' // mostra apenas o valor (ex: 23)
        },
      }]
    };

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
  </script>
  <script>
    function renderCharts() {
      // Chart 1: Ranking por curso
      const dataCourse = JSON.parse(document.getElementById('chart-container3').dataset.value);
      const courseNames = dataCourse.map(item => item.course.name);
      const courseCounts = dataCourse.map(item => item.total);

      const chart1 = echarts.init(document.getElementById('chart-container3'));
      // Combina nomes e valores e ordena do maior para o menor
      const sortedData = courseNames.map((name, index) => ({
        name,
        value: courseCounts[index]
      })).sort((a, b) => b.value - a.value);

      // Extrai os dados reordenados
      const sortedNames = sortedData.map(item => item.name);
      const sortedValues = sortedData.map(item => item.value);

      chart1.setOption({
        tooltip: {
          trigger: 'axis'
        },
        grid: {
          left: '5%',
          right: '5%',
          bottom: '5%',
          top: '5%',
          containLabel: true
        },
        xAxis: {
          type: 'value',
          interval: 3,
          min: 0,
          max: Math.ceil(Math.max(...sortedValues) / 10) * 10,
          axisLabel: {
            fontSize: 12
          }
        },
        yAxis: {
          type: 'category',
          data: sortedNames,
          inverse: true,
          axisLabel: {
            show: false // Esconde os nomes no eixo Y
          }
        },
        series: [{
          name: 'Total',
          type: 'bar',
          data: sortedValues,
          label: {
            show: true,
            position: 'right',
            fontSize: 13,
            fontWeight: 'bold',
            color: '#333',
            formatter: (params) => `${sortedNames[params.dataIndex]}: ${params.value}` // Mostra nome + valor
          },
          itemStyle: {
            color: '#5470C6',
            borderRadius: [10, 10, 10, 10]
          },
          barWidth: 20
        }]
      });


      // Chart 2: Projetos por ano
      const dataProjects = JSON.parse(document.getElementById('chart-container4').dataset.value);
      const anos = dataProjects.map(item => item.ano);
      const totais = dataProjects.map(item => item.total);

      const chart2 = echarts.init(document.getElementById('chart-container4'));
      chart2.setOption({
        tooltip: {
          trigger: 'axis'
        },
        xAxis: {
          type: 'category',
          data: anos
        },
        yAxis: {
          type: 'value',
          interval: 5,
          max: 40
        },
        series: [{
          name: 'Total',
          type: 'line',
          data: totais,
          label: {
            show: true,
            position: 'top'
          },
          itemStyle: {
            color: '#91cc75'
          }
        }]
      });

      // Responsivo
      window.addEventListener('resize', () => {
        chart1.resize();
        chart2.resize();
      });
    }

    document.addEventListener('DOMContentLoaded', renderCharts);
  </script>

  <div id="mapa-ceara" style="width: 100%; height: 600px;"></div>

  <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.2/dist/echarts.min.js"></script>

  <script>
    const chartDataCe = {!! $chartDataCity !!}; // Laravel -> envia dados [{name: "Fortaleza", value: 10}, ...]

    const chart = echarts.init(document.getElementById('mapa-ceara'));

    fetch('/assets/js/geojs-23-mun.json')
      .then(response => response.json())
      .then(geoJson => {
        echarts.registerMap('ceara', geoJson);

        chart.setOption({
          tooltip: {
            trigger: 'item',
            formatter: function(params) {
              return `${params.name}: ${params.value}`;
            }
          },
          visualMap: {
            min: 0,
            max: Math.max(...chartDataCe.map(d => d.value)),
            inRange: {
              color: ['#e0f3f8', '#005824']
            },
            show: false
          },
          series: [{
            name: 'Atividades',
            type: 'map',
            map: 'ceara',
            label: {
              show: false
            },
            data: chartDataCe
          }]
        });
      });
  </script>
@endsection
