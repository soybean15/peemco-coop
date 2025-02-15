<div>
    <div id='bar-chart'></div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function () {
    let apiUrl = @json($apiUrl);


    function fetchChartData() {
        fetch(apiUrl)
            .then(response => response.json())
            .then(data => {
                console.log("Fetched Data:", data.categories); // Debugging
                renderChart(data.categories, data.series);
            })
            .catch(error => console.error("Error fetching chart data:", error));
    }

    function renderChart(categories, values) {
        var options = {
            series: [{
                data: values // Dynamically set values
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    borderRadiusApplication: 'end',
                    horizontal: true,
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: categories, // Dynamically set categories
            }
        };

        var chart = new ApexCharts(document.querySelector("#bar-chart"), options);
        chart.render();
    }

    fetchChartData(); // Load chart data
});
</script>
