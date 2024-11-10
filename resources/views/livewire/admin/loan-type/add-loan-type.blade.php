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
                return $this->dispatch('store-loan-type');
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
            <x-step step="1" text="Register">
                <livewire:admin.loan-type.loan-type-form/>

            </x-step>
            <x-step step="2" text="Payment">
                Payment step
            </x-step>
            <x-step step="3" text="Receive Product" class="bg-orange-500/20">
                Receive Product
            </x-step>
        </x-steps>
    </div>
    <x-button label="Previous" wire:click="prev" />
    <x-button label="Next" wire:click="next" />
</div>
