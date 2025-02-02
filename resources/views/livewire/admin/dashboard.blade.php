<?php

use Livewire\Volt\Component;
use  App\Enums\AppActionsEnum;
use Illuminate\View\View;
use App\Services\Dashboard\DashboardService;

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

    <x-header title="Dashboard" subtitle="Welcome ADmin" separator />

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


    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <x-bar-chart/>
        <x-area-chart/>
        <x-pie-chart/>
        <x-column-chart/>

    </div>
  </div>
</div>
