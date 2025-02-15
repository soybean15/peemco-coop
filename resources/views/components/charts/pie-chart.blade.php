<div>
    <div id='pie-chart'></div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let apiUrl = @json($apiUrl);


    function fetchChartData() {
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                renderChart(data.labels, data.series);
            })
            .catch(error => console.error("Error fetching chart data:", error));
    }

    function renderChart(labels, series) {
        var options = {
            series: series,
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: labels,
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#pie-chart"), options);
        chart.render();
    }

    fetchChartData(); // Call the function to load data on page load
});
</script>
