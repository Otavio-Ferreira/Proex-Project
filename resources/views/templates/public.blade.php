<!doctype html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Proex</title>
  <link href="{{ asset('assets/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/demo.min.css?1684106062') }}" rel="stylesheet" />
  <link rel="shortcut icon" href="{{ asset('assets/img/illustrations/logo-small.svg') }}" type="image/x-icon">
  <link href="{{ asset('assets/css/tabler-icons.min.css') }}" rel="stylesheet" />

  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
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
</head>

<body class="row m-0 p-0 vh-100">
  <div class="page-wrapper">

    <div class="container">
      <div class="page-header">
        <div class="">
          <div class="row g-2 align-items-center">
            <div class="col">

            </div>
            <div class="col-auto ms-auto">
              <div class="btn-list">
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                  Filtros
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="page-body row">
        <div class="collapse mb-3" id="collapseExample">
          <div class="card card-body">
            <form action="{{ route('dashboard_public.dashboard') }}" method="POST" class="row">
              @csrf
              <div class="d-flex col-12 col-md-3">
                <select class="form-select me-1" id="" name="year">
                  <option value="" disabled {{ session('filter_year') === null ? 'selected' : '' }}>Ano</option>
                  @foreach ($forms as $year)
                    @php $yearValue = date('Y', strtotime($year->created_at)); @endphp
                    <option value="{{ $yearValue }}" {{ session('filter_year') == $yearValue ? 'selected' : '' }}>
                      {{ $yearValue }}
                    </option>
                  @endforeach
                  <option value="" {{ session('filter_year') === '' ? 'selected' : '' }}>Tudo</option>
                </select>
              </div>
              <div class="d-flex col-12 col-md-3">
                <select class="form-select me-1" id="" name="form">
                  <option value="" disabled {{ session('filter_form') === null ? 'selected' : '' }}>Formulário
                  </option>
                  @foreach ($forms as $form)
                    <option value="{{ $form->id }}" {{ session('filter_form') == $form->id ? 'selected' : '' }}>
                      {{ $form->title }}
                    </option>
                  @endforeach
                  <option value="" {{ session('filter_form') === '' ? 'selected' : '' }}>Tudo</option>
                </select>
              </div>
              <div class="d-flex col-12 col-md-3">
                <select class="form-select me-1" id="" name="course">
                  <option value="" disabled {{ session('filter_course') === null ? 'selected' : '' }}>Curso
                  </option>
                  @foreach ($courses as $course)
                    <option value="{{ $course->id }}"
                      {{ session('filter_course') == $course->id ? 'selected' : '' }}>
                      {{ $course->name }}
                    </option>
                  @endforeach
                  <option value="" {{ session('filter_course') === '' ? 'selected' : '' }}>Tudo</option>
                </select>
              </div>
              <div class="d-flex col-12 col-md-3">
                <select class="form-select me-1" id="" name="status">
                  <option value="" disabled {{ session('filter_status') === null ? 'selected' : '' }}>Status dos
                    trabalhos</option>
                  <option value="1" {{ session('filter_status') === '1' ? 'selected' : '' }}>Ativos</option>
                  <option value="0" {{ session('filter_status') === '0' ? 'selected' : '' }}>Inativos</option>
                  <option value="" {{ session('filter_status') === '' ? 'selected' : '' }}>Tudo</option>
                </select>
              </div>
              <div class="col-12 d-flex justify-content-end mt-3">
                <button class="btn btn-secondary">Filtrar</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-12">
          <div class="row">
            @foreach ($cards as $item)
              <div class="col-12 col-md-3">
                <div class="alert alert-primary card-body">
                  <div class="pt-3 pb-3">
                    <div class="subheader">{{ $item['title'] }}</div>
                    <div class="d-flex align-items-baseline">
                      <div class="h1 mb-0 me-2">{{ number_format($item['value'], 0, ',', '.') }}</div>
                      <div class="me-auto">
                      </div>
                    </div>
                    <div class="text-secondary mt-2">{{ $item['description'] }}</div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        <div class="col-12 row m-0 p-0">
          <h3 class="text-muted mb-2">Quantidade de projetos por tipo de ações e modalidades</h3>
          <div class="col-6">
            <div id="chart-container" class="w-100 card" data-value='@json($cards_acao[0]['cards'])'></div>
          </div>
          <div class="col-6">
            <div id="chart-container2" class="w-100 card" data-value='@json($cards_acao[1]['cards'])'></div>
          </div>
        </div>

        <div class="col-12 p-0">
          <h3 class="text-muted mb-2">Ranking de projetos da UFCA por ano</h3>
          <div id="chart-container4" class="w-100 card" data-value='{{ $ranking_projects }}'></div>
        </div>

        <div class="col-12">
          <h3 class="text-muted mb-2">Ranking de projetos por cursos</h3>
          <div class="">
            <div id="chart-container3" class="w-100 card" data-value='{{ $ranking_course }}'></div>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer footer-transparent d-print-none">
      <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
          <div class="col-lg-auto ms-lg-auto">
            <ul class="list-inline list-inline-dots mb-0">
              <li class="list-inline-item"><a href="" target="_blank" class="link-secondary"
                  rel="noopener">Suport</a></li>
            </ul>
          </div>
          <div class="col-12 col-lg-auto mt-3 mt-lg-0">
            <ul class="list-inline list-inline-dots mb-0">
              <li class="list-inline-item">
                Copyright &copy; 2025
                <a href="." class="link-secondary">Proex</a>.
                All rights reserved.
              </li>
              <li class="list-inline-item">
                <a href="./changelog.html" class="link-secondary" rel="noopener">
                  v2.0.0-beta
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <script src="{{ asset('assets/js/demo-theme.min.js?1684106062') }}"></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/js/tabler.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/demo.min.js?1684106062') }}" defer></script>
  <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
  <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
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
      title: {
        text: 'Tipo de ação',
        left: 'center',
        top: '2%',
        textStyle: {
          fontSize: 16,
          fontWeight: 'bold'
        }
      },
      tooltip: {
        trigger: 'item'
      },
      legend: {
        orient: 'vertical', // legenda em coluna
        right: '5%', // fixa na direita
        top: 'middle',
      },
      series: [{
        name: 'Tipo de Ação',
        type: 'pie',
        radius: ['40%', '70%'],
        center: ['30%', '60%'],
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
      title: {
        text: 'Tipo de modalidade',
        left: 'center',
        top: '2%',
        textStyle: {
          fontSize: 16,
          fontWeight: 'bold'
        }
      },
      tooltip: {
        trigger: 'item',
        formatter: '{b}: {c}' // mostra nome completo e valor ao passar o mouse sobre o gráfico
      },
      legend: {
        orient: 'vertical',
        right: '5%',
        top: 'middle',

        // aqui fazemos o "corte" dos nomes grandes
        formatter: function(name) {
          const maxLength = 15; // número máximo de caracteres antes de cortar
          return name.length > maxLength ? name.substring(0, maxLength) + '…' : name;
        },

        // adiciona um tooltip HTML com o nome completo
        tooltip: {
          show: true,
          formatter: function(params) {
            return params.name; // mostra o nome completo da legenda
          }
        }
      },
      series: [{
        name: 'Tipo de Ação',
        type: 'pie',
        radius: ['40%', '70%'],
        center: ['30%', '60%'],
        startAngle: 180,
        endAngle: 360,
        data: pieData,
        label: {
          show: true,
          position: 'inside',
          formatter: '{c}'
        }
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
      const courseNames = dataCourse.map(item => item.course_name);
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
          interval: 10,
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
      const max = Math.ceil(Math.max(...totais) / 10) * 10;
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
          interval: (max / 5).toInt,
          max: max,
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
          },
          areaStyle: {}
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
</body>

</html>
