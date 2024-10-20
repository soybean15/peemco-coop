<?php

use Livewire\Volt\Component;

new class extends Component {
    public $totalprincipalAmount;
    public $principalAmount;
    public $termsYears;
    public $terms;
    public $monthlyInstallment;
    public $annualInterestRate;
    public $monthlyInterestRate;
    

    public $otherChargesInterest = 0.06;
 
    public function mount()
    {
        $this->terms = [
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
        ];
    }

    public function compute()
    {

        $this->monthlyInstallment = $this->termsYears * 12;
        $this->totalprincipalAmount = number_format($this->principalAmount, 2, '.', ',');
        dd($this->totalprincipalAmount);

        if($this->termsYears == 5 || $this->termsYears == 4 || $this->termsYears == 3) {
            $this->annualInterestRate = 0.0966;
            $this->monthlyInterestRate = $this->annualInterestRate/12;
        } else if($this->termsYears == 2) {
            $this->annualInterestRate = 0.0900;
            $this->monthlyInterestRate = $this->annualInterestRate/12;
        } else {
            $this->annualInterestRate = 0.0750;
            $this->monthlyInterestRate = $this->annualInterestRate/12;
        }

    }
    
}; ?>

<div>

    <x-form wire:submit.prevent="compute">
        <x-input label="Principal Amount" wire:model="principalAmount" prefix="PHP" money hint="It submits an unmasked value" />
        <x-select label="Terms" :options="$terms" wire:model="termsYears" />
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>


    {{ $totalprincipalAmount }} <br>
    {{ $monthlyInstallment }} <br><br>

    {{$annualInterestRate}}
    {{$monthlyInterestRate}}
</div>
