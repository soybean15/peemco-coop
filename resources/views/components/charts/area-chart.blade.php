<div class="w-full ">
    <div id='area-chart'></div>
</div>
<script>



var series = @json($series)


var options = {
          series: [{
          name:series.name,
          data: series.values
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
          text: '{{ $label }}',
          align: 'left'
        },
        subtitle: {
        //   text: 'Price Movements',
          align: 'left'
        },
        labels: series.labels,
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
