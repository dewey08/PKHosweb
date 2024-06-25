var options = {
    chart: {
        height: 350,
        type: 'radialBar',
    },
    series: [
      45
    ],
    labels: ['Progress'],
  }  
  var chart = new ApexCharts(document.querySelector("#chart"), options);
  
  chart.render();