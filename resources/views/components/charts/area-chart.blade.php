<div>
    <div id='area-chart'></div>
</div>
<script>
    var series = {
  monthDataSeries1: {
    prices: [
      8107.85, 8128.0, 8122.9, 8165.5, 8340.7,
      8423.7, 8423.5, 8514.3, 8481.85, 8487.7,
      8506.9, 8626.2
    ],
    dates: [
      "2023-01-01", "2023-02-01", "2023-03-01", "2023-04-01",
      "2023-05-01", "2023-06-01", "2023-07-01", "2023-08-01",
      "2023-09-01", "2023-10-01", "2023-11-01", "2023-12-01"
    ]
  }
};

var options = {
          series: [{
          name: "STOCK ABC",
          data: series.monthDataSeries1.prices
        }],
          chart: {
          type: 'area',
          height: 350,
          zoom: {
            enabled: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'straight'
        },

        title: {
          text: 'Fundamental Analysis of Stocks',
          align: 'left'
        },
        subtitle: {
          text: 'Price Movements',
          align: 'left'
        },
        labels: series.monthDataSeries1.dates,
        xaxis: {
          type: 'datetime',
        },
        yaxis: {
          opposite: true
        },
        legend: {
          horizontalAlign: 'left'
        }
        };

        var chart = new ApexCharts(document.querySelector("#area-chart"), options);
        chart.render();
</script>
