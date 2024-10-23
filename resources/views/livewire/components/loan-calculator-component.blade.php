<?php

use Livewire\Volt\Component;

use App\Services\LoanCalculator\LoanCalculator;
use App\Services\LoanCalculator\LoanItem;



new class extends Component {

    public $loanItems;
    public $terms;
    public $principal;

    public function mount(){


    }
    public function compute(){
        $loanService = app(LoanCalculator::class);

        $this->loanItems =$loanService
        ->setPrincipal($this->principal)
        ->setTerms($this->terms)
        ->calculateLoan();
    }

}; ?>

<div>
    <x-form wire:submit.prevent="compute">
        <x-input label="Principal Amount" wire:model.defer="principal" prefix="PHP" money hint="It submits an unmasked value" />
        <x-select label="Terms" :options="$terms" wire:model="terms" placeholder="Select Terms"/>
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>

</div>
