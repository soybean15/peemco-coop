<div>

    <div id="chart-container">
        <div id="pie-chart"></div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let apiUrl = @json($apiUrl);
    let pieChartFilter = document.getElementById("pieChartFilter");
    let chart = null; // Store chart instance

    function fetchChartData(param = '') {
        let url = apiUrl + param;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                renderChart(data.labels, data.series);
            })
            .catch(error => console.error("Error fetching chart data:", error));
    }

    function renderChart(labels, series) {
        // Ensure the chart container is reset
        let chartContainer = document.getElementById("chart-container");
        chartContainer.innerHTML = '<div id="pie-chart"></div>'; // Clear & recreate chart div

        var options = {
            series: series.length > 0 ? series : [1], // Ensure at least one value
            chart: {
                width: 380,
                type: 'pie',
            },
            labels: labels.length > 0 ? labels : ["No Loans"], // Default label if empty
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

        // Destroy previous chart instance if it exists
        if (chart && typeof chart.destroy === "function") {
            chart.destroy();
        }

        // Create new chart instance
        chart = new ApexCharts(document.querySelector("#pie-chart"), options);
        chart.render();
    }

    fetchChartData(); // Load chart on page load

    pieChartFilter.addEventListener("change", function () {
        fetchChartData(this.value); // Fetch data based on selected filter
    });
});
</script>
