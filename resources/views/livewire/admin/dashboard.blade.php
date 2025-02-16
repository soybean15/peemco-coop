<?php

use Livewire\Volt\Component;
use App\Services\Dashboard\DashboardService;
use Illuminate\View\View;

new class extends Component {
    public int $totalMembers;
    public int $activeLoanCount;
    public int $pendingLoanCount;
    public float $totalCollection;

    public function rendering(View $view): void
    {
        $view->title('Admin - Profile: Dashboard');
    }

    public function mount(DashboardService $service): void
    {
        $this->totalCollection = $service->getTotalCollection();
        $this->totalMembers = $service->getTotalMembers();
        $this->activeLoanCount = $service->getActiveLoanCount();
        $this->pendingLoanCount = $service->getPendingLoanCount();
    }
};
?>

<div>
    <!-- Header Section -->
    <x-header
        title="Dashboard"
        subtitle="Welcome Admin"
        separator
    />

    <!-- Key Metrics Grid -->
    <div class="grid grid-cols-1 gap-5 md:grid-cols-4">
        <x-stat
            title="Members"
            value="{{ $totalMembers }}"
            description="3 Active today"
        />
        <x-stat
            title="Pending Loan"
            value="{{ $pendingLoanCount }}"
            description="Pending Loan Request"
        />
        <x-stat
            title="Active Loans"
            value="{{ $activeLoanCount }}"
            description="This month"
        />
        <x-stat
            title="Total Collection"
            value="{{ $totalCollection }}"
            description="This month"
        />
    </div>

    <!-- Analytics Section -->
    <section class="mt-6">
        <h2 class="mb-4 text-xl font-bold text-gray-800">
            Analytics Overview
        </h2>
        {{-- <x-card class="md:col-span-2">
            <h3 class="mb-3 text-lg font-semibold text-gray-900">

            </h3>
            <x-column-chart />
        </x-card> --}}
        <div class="flex flex-col gap-6">
            <!-- Top Contributors Chart -->
            <x-card>
                <h3 class="mb-3 text-lg font-semibold text-gray-900">
                    Top Contributors
                </h3>
                <x-bar-chart :apiUrl="route('analytics.top-contributors')" />
            </x-card>

            <!-- Total Loan Timeline Chart -->
            <x-card>
                <h3 class="mb-3 text-lg font-semibold text-gray-900">
                    Total Loan
                </h3>
                <x-timeline-chart :apiUrl="route('analytics.total-loan')" />
            </x-card>

            <!-- Grid for Loan Issued and Comparison Charts -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <!-- Loan Issued Pie Chart -->
                <x-card>
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Loan Issued
                        </h3>
                        <select
                            id="pieChartFilter"
                            class="px-3 py-1 text-sm border border-gray-300 rounded-md"
                        >
                            @for ($year = now()->year; $year > now()->year - 10; $year--)
                                <option value="?year={{ $year }}">
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <x-pie-chart :apiUrl="route('analytics.loan-issued')" />
                </x-card>

                <!-- Loan Comparison Chart -->
                <x-card>
                    <x-loan-comparison-chart />
                </x-card>

                <!-- Top Contributors Column Chart -->

            </div>
        </div>
    </section>
</div>