<?php

use Livewire\Volt\Component;
use  App\Enums\AppActionsEnum;
use Illuminate\View\View;
use App\Services\Dashboard\DashboardService;
use  App\Services\Reports\Analytics;
use App\Enums\FrequencyEnum;
new class extends Component {


    public $totalMembers;
    public $activeLoanCount;
    public $pendingLoanCount;
    public $totalCollection;

    public function rendering(View $view): void
    {
        $view->title('Admin - Profile: Dashboard');


    }
    public function mount(DashboardService $service){


        $this->totalCollection = $service->getTotalCollection();

        $this->totalMembers = $service->getTotalMembers();
        $this->activeLoanCount = $service->getActiveLoanCount();
        $this->pendingLoanCount = $service->getPendingLoanCount();




    }
}; ?>

<div>
  <div>

    <x-header title="Dashboard" subtitle="Welcome Admin" separator />

    <div class="grid grid-cols-1 gap-5 md:grid-cols-4" >
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

    <div class="mt-6 rounded-lg">
        <h2 class="mb-4 text-xl font-bold text-gray-800">Analytics Overview</h2>
        <div class="flex flex-col gap-6">
            <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
                <h3 class="mb-3 text-lg font-semibold text-gray-900">Top Contributors</h3>
                <x-bar-chart :apiUrl="route('analytics.top-contributors')" />
            </div>
            <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
                <h3 class="mb-3 text-lg font-semibold text-gray-900">Total Loan</h3>
                <x-timeline-chart :apiUrl="route('analytics.total-loan')" />
            </div>
            <div class="p-6 bg-white border border-gray-200 shadow-md rounded-xl">
                <h3 class="mb-3 text-lg font-semibold text-gray-900">Loan Issued</h3>
                <x-pie-chart :apiUrl="route('analytics.loan-issued')" />
            </div>
        </div>
    </div>
  </div>
</div>
