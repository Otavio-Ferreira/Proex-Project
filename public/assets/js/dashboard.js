//Script exemplo de gráficos

// $(document).ready(function () {
//     var dom = document.getElementById('chart-one-container');
//     var myChart = echarts.init(dom, null, {
//         renderer: 'canvas',
//         useDirtyRect: false
//     });

//     // Extrair os dados do atributo data-resultados usando attr
//     var resultadosRaw = $('#chart-one').attr('data-resultados');
//     var resultados = resultadosRaw ? JSON.parse(resultadosRaw) : {};

//     console.log('Dados recebidos:', resultados);

//     var dimensoes = [];
//     var seriesData = [];
//     var legendData = [];

//     // Preparar dimensões e dados das séries
//     if (Object.keys(resultados).length > 0) {
//         // Extrair dimensões (indicadores) do primeiro município encontrado
//         var firstMunicipio = resultados[Object.keys(resultados)[0]];
//         dimensoes = Object.keys(firstMunicipio[0]['dimensoes']);

//         // Preparar dados das séries para cada município e formulário
//         $.each(resultados, function (municipio, formularios) {
//             $.each(formularios, function (index, formulario) {
//                 var municipioSeries = {
//                     name: municipio + '(' + (index + 1) + ')',  // Adicionando índice para nomes únicos
//                     type: 'line',
//                     data: []
//                 };

//                 $.each(dimensoes, function (dimensaoIndex, dimensao) {
//                     var valor = formulario['dimensoes'][dimensao] ? parseFloat(formulario['dimensoes'][dimensao]['media_ponderada']).toFixed(2) : 0;
//                     municipioSeries.data.push(valor);
//                 });

//                 seriesData.push(municipioSeries);
//                 legendData.push(municipioSeries.name);
//             });
//         });
//     }

//     console.log('Dados preparados para o gráfico:', seriesData);

//     var shortDimensoes = dimensoes.map(function (dimensao) {
//         return dimensao.slice(0, 3); // Pegar as três primeiras letras de cada dimensão
//     });

//     var option = {
//         tooltip: {
//             trigger: 'axis',
//             backgroundColor: '#f2f2f2',
//             borderColor: '#ccc',
//             textStyle: {
//                 color: '#333'
//             },
//             axisPointer: {
//                 type: 'cross',
//                 crossStyle: {
//                     color: '#999'
//                 }
//             },
//             formatter: function (params) {
//                 var tooltipText = '';
//                 params.forEach(function (param) {
//                     tooltipText += param.marker + param.seriesName + '<br>' + dimensoes[param.dataIndex] + ': <b>' + param.value + '</b><br>';
//                 });
//                 return tooltipText;
//             }
//         },
//         legend: {
//             data: legendData,
//             top: '0',
//             left: '0',
//             textStyle: {
//                 fontSize: 12,
//                 fontWeight: 'bold',
//             }
//         },
//         grid: {
//             left: '3%',
//             right: '4%',
//             bottom: '3%',
//             containLabel: true
//         },
//         toolbox: {
//             feature: {
//                 saveAsImage: {}
//             }
//         },
//         xAxis: {
//             type: 'category',
//             boundaryGap: false,
//             data: shortDimensoes,
//             axisLine: {
//                 lineStyle: {
//                     color: '#333'
//                 }
//             },
//             axisLabel: {
//                 interval: 0, // Mostrar todos os rótulos
//                 formatter: function (value, index) {
//                     return shortDimensoes[index];
//                 }
//             },
//             tooltip: {
//                 show: true,
//                 formatter: function (params) {
//                     return dimensoes[params.dataIndex];
//                 }
//             }
//         },
//         yAxis: {
//             type: 'value',
//             axisLine: {
//                 lineStyle: {
//                     color: '#333'
//                 }
//             },
//             splitLine: {
//                 lineStyle: {
//                     type: 'dashed'
//                 }
//             }
//         },
//         series: seriesData
//     };

//     // Aplicar opções ao gráfico ECharts
//     if (option && typeof option === 'object') {
//         myChart.setOption(option);
//     }

//     // Redimensionar o gráfico quando a janela for redimensionada
//     window.addEventListener('resize', function () {
//         myChart.resize();
//     });
// });
