<div class="p-6 bg-white rounded-lg shadow-md">
    <h3 class="mb-4 text-lg font-semibold text-gray-800">Loan Average Comparison</h3>

    <div class="flex flex-col gap-4 mb-6 sm:flex-row">
        <select id="year1" class="px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
            @for ($i = date('Y'); $i >= 2000; $i--)
                <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>

        <select id="year2" class="px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-indigo-500">
            @for ($i = date('Y'); $i >= 2000; $i--)
                <option value="{{ $i }}" {{ $i == date('Y') - 1 ? 'selected' : '' }}>{{ $i }}</option>
            @endfor
        </select>

        <button onclick="fetchComparison()" class="px-6 py-2 text-white transition bg-indigo-600 rounded-lg hover:bg-indigo-700">
            Compare
        </button>
    </div>

    <div id="comparison-result" class="space-y-6"></div>
</div>

<script>
function fetchComparison() {
    const year1 = document.getElementById('year1').value;
    const year2 = document.getElementById('year2').value;

    fetch(`{{ route('analytics.average-loan-comparison') }}?year1=${year1}&year2=${year2}`)
        .then(response => response.json())
        .then(data => {
            displayResults(data);
        });
}

function displayResults(data) {
    const percentageChange =data.percentage_change;
    const changeClass = percentageChange >= 0 ? 'text-green-600 bg-green-100' : 'text-red-600 bg-red-100';
    const changeSymbol = percentageChange >= 0 ? '▲' : '▼';

    const resultHtml = `
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="p-6 text-center border rounded-lg shadow-sm bg-gray-50">
                <div class="text-sm text-gray-500">${data.year1.year} Average</div>
                <div class="text-2xl font-bold text-gray-800">P${data.year1.average}</div>
            </div>
            <div class="p-6 text-center border rounded-lg shadow-sm bg-gray-50">
                <div class="text-sm text-gray-500">${data.year2.year} Average</div>
                <div class="text-2xl font-bold text-gray-800">P${data.year2.average}</div>
            </div>
        </div>
        <div class="flex justify-center mt-6">
            <div class="px-6 py-3 rounded-lg ${changeClass} text-lg font-semibold shadow-md">
                ${changeSymbol} ${Math.abs(percentageChange)}% Change
            </div>
        </div>
    `;

    document.getElementById('comparison-result').innerHTML = resultHtml;
}

// Initial load
document.addEventListener('DOMContentLoaded', fetchComparison);
</script>
