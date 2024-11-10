<?php

use Livewire\Volt\Component;
use  App\Services\LoanType\LoanTypeService;
use Livewire\Attributes\On;

new class extends Component {
    //
    public $step=1;

    public function next(){



        switch($this->step){
            case 1:
                return $this->dispatch('submit-loan-type');
            case 2:
                return $this->dispatch('submit-loan-type-details');
            case 3:
                return $this->dispatch('submit-loan-type-complete');
            default:
                return;
        }

    }
    public function prev(){
        if($this->step>1)
        $this->step--;
    }

    #[On('move-next-step')]
    public function moveNextStep(){



        $this->step++;

    }
}; ?>

<div>

    <div class="grid grid-cols-1 md:grid-cols-2">
        <x-steps wire:model="step" class="p-5 my-5 border ">
            <x-step step="1" text="Create">
                <livewire:admin.loan-type.loan-type-form/>

            </x-step>
            <x-step step="2" text="Add Users">
                <livewire:admin.loan-type.loan-type-user/>

            </x-step>
            <x-step step="3" text="Review Loan Type" class="">
                <livewire:admin.loan-type.loan-type-review/>
            </x-step>
        </x-steps>
    </div>

    @if($step==3)
    <x-button label="Back" wire:click="prev" />
    <x-button label="Finish" wire:click="next" class="btn btn-success" />
    @else
    <x-button label="Previous" wire:click="prev" />
    <x-button label="Next" wire:click="next" />
    @endif

</div>
