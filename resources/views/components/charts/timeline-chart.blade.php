<div>
    <div class="chart-header">
        <div class="btn-group">
            <button id="one_month" class="active">1M</button>
            <button id="six_months">6M</button>
            <button id="one_year">1Y</button>
            <button id="ytd">YTD</button>
            <button id="all">ALL</button>
        </div>
    </div>
    <div id="chart-timeline"></div> <!-- Fixed ID to match JavaScript -->
</div>
<script>


document.addEventListener("DOMContentLoaded", function () {

    let apiUrl = @json($apiUrl);

    function fetchChartData() {
      fetch(apiUrl) // Use the dynamically passed API URL
        .then(response => response.json())
        .then(data => {

          renderChart(data['total_amount_issued']['data']);
        })
        .catch(error => console.error("Error fetching chart data:", error));
    }
    fetchChartData();



  function renderChart(data) {

    var options = {
      series: [{ data: data }], // Inject fetched data
      chart: {
        id: "area-datetime",
        type: "area",
        height: 350,
        zoom: { autoScaleYaxis: true }
      },
      annotations: {
        yaxis: [{
          y: 30,
          borderColor: "#999",
          label: {
            show: true,
            text: "Support",
            style: { color: "#fff", background: "#00E396" }
          }
        }],
        xaxis: [{
          x: new Date("14 Nov 2012").getTime(),
          borderColor: "#999",
          yAxisIndex: 0,
          label: {
            show: true,
            text: "Rally",
            style: { color: "#fff", background: "#775DD0" }
          }
        }]
      },
      dataLabels: { enabled: false },
      markers: { size: 0, style: "hollow" },
      xaxis: {
        type: "datetime",
        min: new Date("01 Mar 2012").getTime(),
        tickAmount: 6
      },
      tooltip: { x: { format: "dd MMM yyyy" } },
      fill: {
        type: "gradient",
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.9,
          stops: [0, 100]
        }
      }
    };

    var chart = new ApexCharts(document.querySelector("#chart-timeline"), options);
    chart.render();

    var resetCssClasses = function (activeEl) {
      document.querySelectorAll("button").forEach(el => el.classList.remove("active"));
      activeEl.target.classList.add("active");
    };

    document.querySelector("#one_month").addEventListener("click", function (e) {
    resetCssClasses(e);
    let today = new Date();
    let oneMonthAgo = new Date();
    oneMonthAgo.setMonth(today.getMonth() - 1);
    chart.zoomX(oneMonthAgo.getTime(), today.getTime());
});

document.querySelector("#six_months").addEventListener("click", function (e) {
    resetCssClasses(e);
    let today = new Date();
    let sixMonthsAgo = new Date();
    sixMonthsAgo.setMonth(today.getMonth() - 6);
    chart.zoomX(sixMonthsAgo.getTime(), today.getTime());
});

document.querySelector("#one_year").addEventListener("click", function (e) {
    resetCssClasses(e);
    let today = new Date();
    let oneYearAgo = new Date();
    oneYearAgo.setFullYear(today.getFullYear() - 1);
    chart.zoomX(oneYearAgo.getTime(), today.getTime());
});

document.querySelector("#ytd").addEventListener("click", function (e) {
    resetCssClasses(e);
    let today = new Date();
    let startOfYear = new Date(today.getFullYear(), 0, 1); // January 1st of this year
    chart.zoomX(startOfYear.getTime(), today.getTime());
});

document.querySelector("#all").addEventListener("click", function (e) {
    resetCssClasses(e);
    chart.zoomX(new Date("2020-01-01").getTime(), new Date().getTime()); // Adjust start date as needed
});

  }
});

</script>

<style>
    .chart-header {
        margin-bottom: 1rem;
        display: flex;
        justify-content: flex-end;
    }

    .btn-group button {
        padding: 0.25rem 0.5rem;
        margin-left: 0.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        background-color: white;
        cursor: pointer;
    }

    .btn-group button.active {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
    </style>
