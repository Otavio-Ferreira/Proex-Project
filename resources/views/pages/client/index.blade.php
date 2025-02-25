@extends('templates.client')

@section('content')
  <div class="page-body">
    <div class="">
      <div class="row row-cards">
        <a href="{{ route('client.show', [$obra->COD_OBRAS, 'custos']) }}" class="col-6 col-lg-3 text-decoration-none">
          <div class="card border-0 card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-orange-lt rounded-5 avatar">
                    <i class="icon ti ti-moneybag text-orange"></i>
                  </span>
                </div>
                <div class="col">
                  <div class="text-secondary">
                    Carteira
                  </div>
                  <div class="fw-bold">
                    R$ {{ number_format($obra->CARTEIRA, '2', ',', '.') }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </a>
        @foreach ($costs as $key => $cost)
          <a href="{{ route('client.show', [$obra->COD_OBRAS, 'custos']) }}" class="col-6 col-lg-3 text-decoration-none">
            <div class="card border-0 card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="{{ $cost[0]['background'] }} rounded-5 avatar">
                      <i class="icon ti {{ $cost[0]['icon'] . ' ' . $cost[0]['color'] }}"></i>
                    </span>
                  </div>
                  <div class="col">
                    <div class="text-secondary">
                      {{ ucfirst($key) }}
                    </div>
                    <div class="fw-bold">
                      R$ {{ number_format($cost[1]->sum('VALOR'), '2', ',', '.') }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
    <div class="row mt-3">
      <div id="evolucao" class="col-12 col-lg-6 mb-3">
        <div class="mb-2 d-flex justify-content-between">
          <p class="m-0 form-label" style="color: #333B69; font-size: 16px">Evolução da Obra</p>
          <a class="m-0 text-decoration-none" href="{{ route('client.show', [$obra->COD_OBRAS, 'evolucao']) }}">Ver mais <i class="ti ti-caret-down"></i></a>
        </div>
        <div id="chart" class="bg-white p-2 rounded-3 d-flex flex-wrap justify-content-center align-content-center"
          data-evolucao="{{ json_encode($valores_evolucao) }}"></div>
      </div>
      <div id="cronograma" class="col-12 col-lg-6 mb-3">
        <div class="mb-2 d-flex justify-content-between">
          <p class="m-0 form-label" style="color: #333B69; font-size: 16px">Cronograma da Obra</p>
          <a class="m-0 text-decoration-none" href="{{ route('client.show', [$obra->COD_OBRAS, 'evolucao']) }}">Ver mais <i class="ti ti-caret-down"></i></a>
        </div>
        <div id="chart-two" class="bg-white p-2 rounded-3 d-flex flex-wrap justify-content-center align-content-center"
          data-cronograma="{{ json_encode($valores_cronograma) }}"></div>
      </div>
      <div id="orcameto" class="col-12 col-lg-6 mb-3">
        <div class="mb-2 d-flex justify-content-between">
          <p class="m-0 form-label" style="color: #333B69; font-size: 16px">Consumo do orçamento</p>
          <a class="m-0 text-decoration-none" href="{{ route('client.show', [$obra->COD_OBRAS, 'orcamento']) }}">Ver mais <i class="ti ti-caret-down"></i></a>
        </div>
        <div id="chart-three" class="bg-white p-2 rounded-3 d-flex flex-wrap justify-content-center align-content-center"
          data-consumo="{{ json_encode($valores_custos) }}"></div>
      </div>
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-2 d-flex justify-content-between">
          <p class="m-0 form-label" style="color: #333B69; font-size: 16px">Orçamento da Obra</p>
          <a class="m-0 text-decoration-none" href="{{ route('client.show', [$obra->COD_OBRAS, 'orcamento']) }}">Ver mais <i class="ti ti-caret-down"></i></a>
        </div>
        <div id="chart-four" class="bg-white p-2 rounded-3 d-flex flex-wrap justify-content-center align-content-center"
          data-valores-custo-etapas="{{ json_encode($valores_custos_etapas) }}"></div>
      </div>
      <div id="custos" class="col-12 col-lg-6 mb-3">
        <div class="mb-2 d-flex justify-content-between">
          <p class="m-0 form-label" style="color: #333B69; font-size: 16px">Custos de obra</p>
          <a class="m-0 text-decoration-none" href="{{ route('client.show', [$obra->COD_OBRAS, 'custos']) }}">Ver mais <i class="ti ti-caret-down"></i></a>
        </div>
        <div id="chart-six" class="bg-white p-2 rounded-3 d-flex flex-wrap justify-content-center align-content-center"
          data-valores-custos-reais="{{ json_encode($valores_custos_reais) }}"></div>
      </div>
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-2 d-flex justify-content-between">
          <p class="m-0 form-label" style="color: #333B69; font-size: 16px">Custo por categorias</p>
          <a class="m-0 text-decoration-none" href="{{ route('client.show', [$obra->COD_OBRAS, 'custos']) }}">Ver mais <i class="ti ti-caret-down"></i></a>
        </div>
        <div id="chart-five" class="bg-white d-flex justify-content-center p-2 rounded-3"
          data-valores-custos-categorias="{{ json_encode($valores_custos_categorias) }}"></div>
      </div>
      <div>
        @foreach ($valores_custos_categorias as $item)
          <div class="bg-white rounded-3 p-2 mb-3">
            <div class="card-body d-flex flex-wrap justify-content-between align-content-center align-items-center">
              <div class="d-flex py-1 align-items-center">
                <span class="bg-blue-lt p-1 ps-2 pe-2 rounded me-3 ms-1">
                  <i class="ti ti-credit-card-filled fs-1"></i>
                </span>
                <div class="flex-fill">
                  <div class="fw-bold">{{ $item['categoria'] }}</div>
                  <div class="text-secondary fw-light fs-5">
                    R$ {{ number_format($item['valor'], 2, ',', '.') }}
                  </div>
                </div>
              </div>
              <div class="align-items-center">
                <a href="{{ route('client.show', [$obra->COD_OBRAS, 'custos']) }}" class="text-blue fw-bold me-2">Ver
                  detalhes</a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
@section('scripts')
  <script>
    var valores = JSON.parse(document.querySelector('#chart').getAttribute('data-evolucao'));

    var categorias = [];
    var data = [];

    for (var key in valores) {
      if (valores.hasOwnProperty(key)) {
        categorias.push(valores[key].mes);
        data.push(valores[key].valor);
      }
    }

    var options = {
      series: [{
        name: "Valor",
        data: data // Valores para o eixo Y
      }],
      chart: {
        height: 250,
        type: 'line',
        background: '#FFFFFF',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight',
        width: 2,
        colors: ['#EDA10D']
      },
      markers: {
        size: 6,
        colors: ['#EDA10D'],
        strokeColors: '#fff',
        strokeWidth: 2,
        hover: {
          size: 8
        }
      },
      grid: {
        borderColor: '#111',
        strokeDashArray: 7
      },
      xaxis: {
        categories: categorias, // Abreviação do mês no eixo X
        labels: {
          style: {
            colors: '#000',
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        min: 0,
        max: 100,
        tickAmount: 5,
        labels: {
          style: {
            colors: '#000',
            fontSize: '12px',
            fontFamily: 'Arial, sans-serif'
          },
          formatter: function(value) {
            return value.toFixed(0) + " %";
          }
        },
        tickPlacement: 'on'
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val.toFixed(2) + "%";
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
  </script>
  <script>
    const cronogramaData = JSON.parse(document.querySelector('#chart-two').getAttribute('data-cronograma'));

    // Extract the categories (months) and the 'Previsto' and 'Realizado' data from the cronogramaData
    const categories = [];
    const previstoData = [];
    const realizadoData = [];

    Object.keys(cronogramaData).forEach(key => {
      const item = cronogramaData[key];
      categories.push(item.mes); // Add the month (e.g., 'Set', 'Out')
      previstoData.push(item.esperado); // Add the 'esperado' value
      realizadoData.push(item.alcancado); // Add the 'alcancado' value
    });

    const maxValue = Math.max(...previstoData, ...realizadoData);

    // Arredondar para o número inteiro mais próximo
    const maxRounded = Math.ceil(maxValue / 10) * 10;
    var options = {
      series: [{
        name: 'Previsto',
        data: previstoData
      }, {
        name: 'Realizado',
        data: realizadoData
      }],
      chart: {
        height: 250,
        type: 'bar',
        background: '#FFFFFF',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      legend: {
        position: "top",
        horizontalAlign: 'right',
      },
      grid: {
        borderColor: '#111',
        strokeDashArray: 7
      },
      plotOptions: {
        bar: {
          borderRadius: 5,
          horizontal: false,
          columnWidth: '30%'
        },
      },
      colors: ['#16DBCC', '#1814F3'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: categories, // Use dynamically generated categories
      },
      yaxis: {
        min: 0,
        max: maxRounded,
        tickAmount: 5,
        labels: {
          style: {
            colors: '#000',
            fontSize: '12px',
            fontFamily: 'Arial, sans-serif'
          },
          formatter: function(value) {
            return value.toFixed(0) + " %";
          }
        },
        tickPlacement: 'on'
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val.toFixed(2) + " %";
          }
        }
      }
    };


    var chart = new ApexCharts(document.querySelector("#chart-two"), options);
    chart.render();
  </script>
  <script>
    var valoresConsumo = JSON.parse(document.querySelector('#chart-three').getAttribute('data-consumo'));

    var categoriasConsumo = [];
    var dataConsumo = [];
    var valoresReais = [];

    for (var key in valoresConsumo) {
      if (valoresConsumo.hasOwnProperty(key)) {
        categoriasConsumo.push(valoresConsumo[key].mes);
        dataConsumo.push(valoresConsumo[key].porcento);
        valoresReais.push(valoresConsumo[key].valor);
      }
    }

    const maxValueg3 = Math.max(...dataConsumo);
    const magnitudeg3 = Math.pow(1, Math.floor(Math.log10(maxValueg3)));
    const maxRoundedg3 = Math.ceil(maxValueg3 / magnitudeg3) * magnitudeg3;

    var options = {
      series: [{
        name: "Porcentagem",
        data: dataConsumo,
      }],
      chart: {
        height: 250,
        type: 'line',
        background: '#FFFFFF',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight',
        width: 2,
        colors: ['#396AFF']
      },
      markers: {
        size: 6,
        colors: ['#396AFF'],
        strokeColors: '#fff',
        strokeWidth: 2,
        hover: {
          size: 8
        }
      },
      grid: {
        borderColor: '#111',
        strokeDashArray: 7
      },
      xaxis: {
        categories: categoriasConsumo,
        labels: {
          style: {
            colors: '#000',
            fontSize: '12px'
          }
        }
      },
      yaxis: {
        min: 0,
        max: maxRoundedg3,
        tickAmount: 5,
        labels: {
          style: {
            colors: '#000',
            fontSize: '12px',
            fontFamily: 'Arial, sans-serif'
          },
          formatter: function(value) {
            return value.toFixed(0) + " %";
          }
        },
        tickPlacement: 'on'
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return val.toFixed(2) + "%";
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart-three"), options);
    chart.render();
  </script>
  <script>
    const custosEtapas = JSON.parse(document.querySelector('#chart-four').getAttribute('data-valores-custo-etapas'));

    const categoriesEtapas = [];
    const previstoEtapa = [];
    const realEtapa = [];

    Object.keys(custosEtapas).forEach(key => {
      const item = custosEtapas[key];
      categoriesEtapas.push(item.etapa); // Add the month (e.g., 'Set', 'Out')
      previstoEtapa.push(item.estimado); // Add the 'esperado' value
      realEtapa.push(item.real); // Add the 'alcancado' value
    });

    const maxValue2 = Math.max(...previstoEtapa, ...realEtapa);
    const magnitude = Math.pow(10, Math.floor(Math.log10(maxValue2)));
    const maxRounded2 = Math.ceil(maxValue2 / magnitude) * magnitude;

    var options = {
      series: [{
        name: 'Previsto',
        data: previstoEtapa
      }, {
        name: 'Realizado',
        data: realEtapa
      }],
      chart: {
        height: 250,
        type: 'bar',
        background: '#FFFFFF',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      legend: {
        position: "top",
        horizontalAlign: 'right',
      },
      grid: {
        borderColor: '#111',
        strokeDashArray: 7
      },
      plotOptions: {
        bar: {
          borderRadius: 5,
          horizontal: false,
          columnWidth: '30%'
        },
      },
      colors: ['#FC7900', '#1814F3'],
      dataLabels: {
        enabled: false
      },
      stroke: {
        show: true,
        width: 2,
        colors: ['transparent']
      },
      xaxis: {
        categories: categoriesEtapas,
      },
      yaxis: {
        min: 0,
        max: maxRounded2,
        tickAmount: 5,
        labels: {
          style: {
            colors: '#000',
            fontSize: '12px'
          },
          formatter: function(value) {
            return value / 1000 + "K";
          }
        },
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        y: {
          formatter: function(val) {
            return 'R$ ' + val.toLocaleString('pt-BR', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
          }
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart-four"), options);
    chart.render();
  </script>
  <script>
    var valores = JSON.parse(document.querySelector('#chart-five').getAttribute('data-valores-custos-categorias'));

    var categoriasCategoria = [];
    var dataCategorias = [];

    for (var key in valores) {
      if (valores.hasOwnProperty(key)) {
        categoriasCategoria.push(valores[key].categoria);
        dataCategorias.push(valores[key].valor);
      }
    }

    var options = {
      chart: {
        height: 285,
        type: 'pie',
        background: '#fff',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      labels: categoriasCategoria,
      series: dataCategorias, // Percentuais de cada etapa
      colors: ['#3f3f6f', '#ff7300', '#ff00b3', '#1800ff'], // Cores personalizadas
      title: {
        show: false
      },
      plotOptions: {
        pie: {
          expandOnClick: false, // Desabilita a animação de clique
          customScale: 1,
          offsetX: 0,
          offsetY: 0,
          dataLabels: {
            offset: -10, // Ajusta a posição dos labels
            minAngleToShowLabel: 10
          }
        }
      },
      stroke: {
        show: true,
        width: 5, // Aumenta o espaçamento entre as fatias
        colors: '#fff' // Cor do espaçamento (mesma cor do fundo)
      },
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return val.toFixed(0) + '%';
        },
        style: {
          fontSize: '16px',
          fontWeight: 'bold',
          colors: ['#fff']
        },
        dropShadow: {
          enabled: false,
          top: 1,
          left: 1,
          blur: 2,
          color: '#000',
          opacity: 0.6
        }
      },
      legend: {
        show: false
      },
      tooltip: {
        theme: 'light', // Tema leve para o tooltip
        style: {
          fontSize: '12px', // Ajuste do tamanho da fonte
          fontFamily: 'Arial, sans-serif' // Fonte personalizada
        },
        y: {
          formatter: function(val) {
            return 'R$ ' + val.toLocaleString('pt-BR', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
          }
        },
        marker: {
          show: false // Remove o marcador na borda do tooltip
        },
        fillSeriesColor: false, // Tooltip usa uma cor fixa, não a cor da série
        background: {
          enabled: true,
          borderRadius: 8, // Deixa as bordas mais suaves
          borderWidth: 1, // Reduz a espessura da borda
          borderColor: '#E0E0E0', // Cor mais leve para a borda
          shadow: {
            enabled: true,
            blur: 5,
            color: 'rgba(0, 0, 0, 0.15)', // Sombra leve para um efeito suave
            offsetX: 2,
            offsetY: 2
          }
        }
      },
    };

    var chart = new ApexCharts(document.querySelector("#chart-five"), options);
    chart.render();
  </script>
  <script>
    var valores = JSON.parse(document.querySelector('#chart-six').getAttribute('data-valores-custos-reais'));

    var categoriasCustosReais = [];
    var dataCustosReais = [];

    for (var key in valores) {
      if (valores.hasOwnProperty(key)) {
        categoriasCustosReais.push(valores[key].mes);
        dataCustosReais.push(valores[key].valor);
      }
    }

    var options = {
      series: [{
        name: 'Valor',
        data: dataCustosReais
      }],
      chart: {
        height: 250,
        type: 'bar',
        toolbar: {
          show: false
        },
        zoom: {
          enabled: false
        }
      },
      colors: ["#16DBCC"],
      plotOptions: {
        bar: {
          borderRadius: 10,
          dataLabels: {
            position: 'top', // top, center, bottom
          },
        }
      },
      dataLabels: {
        enabled: true,
        formatter: function(val) {
          return 'R$ ' + val.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
        },
        offsetY: -20,
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
        axisBorder: {
          show: false
        },
        axisTicks: {
          show: false,
        },
        labels: {
          show: false,
          formatter: function(val) {
            return val.toLocaleString('pt-BR', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
          }
        }

      }
    };

    var chart = new ApexCharts(document.querySelector("#chart-six"), options);
    chart.render();
  </script>
@endsection
