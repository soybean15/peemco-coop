<?php

use Livewire\Volt\Component;
use App\Services\Dashboard\UserDashboardService;
use Illuminate\View\View;

new class extends Component {

    public int $activeLoanCount;
    public int $pendingLoanCount;
    public float $totalCBU;

    public function rendering(View $view): void
    {
        $view->title('User - Profile: Dashboard');
    }

    public function mount(UserDashboardService $service): void
    {
        $this->totalCBU = $service->getTotalCbu();
     
        $this->activeLoanCount = $service->getActiveLoanCount();
       
    }
}; ?>

<div>
    <x-header
    title="Dashboard"
    subtitle="Welcome Member"
    separator
/>
<div class="grid grid-cols-1 gap-5 md:grid-cols-4">
    <x-stat
        title="Capital build up"
        value="{{ $totalCBU }}"

    />
   
    <x-stat
        title="Active Loans"
        value="{{ $activeLoanCount }}"
        description="This month"
    />

</div>

</div>
