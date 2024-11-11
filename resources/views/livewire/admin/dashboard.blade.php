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

    <x-header title="Dashboard" subtitle="Welcome Adnub" separator />


    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <x-bar-chart/>
        <x-area-chart/>
        <x-pie-chart/>
        <x-column-chart/>

    </div>
  </div>
</div>
