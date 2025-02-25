$(document).ready(function () {
  var url_chart = $('#url_chart').attr('url-chart');

  $.ajax({
    url: url_chart,
    method: 'GET',
  }).done(function (data) {
    var dimensions = data.map(item => item.titulo_dimensao);
    var values = data.map(item => item.media_ponderada);

    var dom = document.getElementById('chart-container');
    var myChart = echarts.init(dom, null, {
      renderer: 'canvas',
      useDirtyRect: false
    });

    var option = {
      radar: {
        indicator: dimensions.map(d => ({ name: d, max: 5 })),
      },
      series: [{
        name: 'Dimensões',
        type: 'radar',
        data: [{
          value: values,
          name: 'Média Ponderada',
          label: {
            show: true,
            formatter: function (params) {
              return params.value;
            }
          }
        }]
      }]
    };

    if (option && typeof option === 'object') {
      myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
  });
});
