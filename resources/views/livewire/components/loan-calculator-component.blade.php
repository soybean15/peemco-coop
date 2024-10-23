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

        $this->validate(
            [
                'terms'=>'required',
                'principal'=>'required'
            ]
    );

        $this->loanItems =$loanService
        ->setPrincipal($this->principal)
        ->setTerms($this->terms)
        ->calculateLoan();
    }

}; ?>

<div>
    <x-form wire:submit.prevent="compute">
        <x-input label="Principal Amount" wire:model.defer="principal" prefix="PHP" money
            hint="It submits an unmasked value" />
        <x-select label="Terms" :options=" [
            [
                'id' => 1,
                'name' => '1 Year'
            ],
            [
                'id' => 2,
                'name' => '2 Years',
            ],
            [
                'id' => 3,
                'name' => '3 Years',
            ],
            [
                'id' => 4,
                'name' => '4 Years',
            ],
            [
                'id' => 5,
                'name' => '5 Years',
            ]
        ]" wire:model="terms" placeholder="Select Terms" />
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Compute" class="btn-primary" type="compute" spinner="compute" />
        </x-slot:actions>
    </x-form>

</div>
