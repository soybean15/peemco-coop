<?php

use Livewire\Volt\Component;
use  App\Enums\AppActionsEnum;
new class extends Component {

    public function mount(){


//         try{
//             $actions = array_map(fn($case) => $case->getActions(), AppActionsEnum::cases());

// dd($actions);
//         }catch(\Exception $e){
//             dd($e);
//         }

    }
}; ?>

<div>
  <div>

    <x-header title="Dashboard" subtitle="Welcome ADmin" separator />

    <div class="grid grid-cols-1 gap-5 md:grid-cols-4">
        <x-stat
            title="Members"
            value="5"
            description="3 Active today"
        />
        <x-stat
        title="Pending Loan"
        value="5"
        description="Pending Loan Request"
        />
        <x-stat
        title="Total Loan Approved "
        value="33"
        description="This month"
        />
        <x-stat
        title="Revenue "
        value="5,000"
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
