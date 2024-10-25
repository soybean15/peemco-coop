<?php

use Livewire\Volt\Component;

new class extends Component {
    // public $totalprincipalAmount;
    // public $principalAmount=0;
    // public $termsYears;
    // public $terms;
    // public $monthlyInstallment;
    // public $annualInterestRate;
    // public $monthlyInterestRate;

    // public $otherChargesInterest = 0.06;
    // public $otherCharges;
    // public $netProceeds;
    // public $totalNetProceeds;
    // public $monthlyPayment;
    // public $totalMonthlyPaymentRound;
    // public $totalMonthlyPayment;

    // public $outstandingBalance;
    // public $installmentDetails = array();

    // public $month;
    // public $interest;
    // public $principalPaid;
    // public $netP;
    // public $Charges;
    // public $totalOtherCharges;





    // public function mount()
    // {
    //     $this->terms = [
    //         [
    //             'id' => 1,
    //             'name' => '1 Year'
    //         ],
    //         [
    //             'id' => 2,
    //             'name' => '2 Years',
    //         ],
    //         [
    //             'id' => 3,
    //             'name' => '3 Years',
    //         ],
    //         [
    //             'id' => 4,
    //             'name' => '4 Years',
    //         ],
    //         [
    //             'id' => 5,
    //             'name' => '5 Years',
    //         ]
    //     ];



    // }

    // public function compute()
    // {

    //     $this->monthlyInstallment = $this->termsYears * 12;
    //     $this->totalprincipalAmount = number_format($this->principalAmount, 2, '.', ',');


    //     if($this->termsYears == 5 || $this->termsYears == 4 || $this->termsYears == 3) {
    //         $this->annualInterestRate = 0.0966;
    //         $this->monthlyInterestRate = $this->annualInterestRate/12;
    //     } else if($this->termsYears == 2) {
    //         $this->annualInterestRate = 0.0900;
    //         $this->monthlyInterestRate = $this->annualInterestRate/12;
    //     } else {
    //         $this->annualInterestRate = 0.0750;
    //         $this->monthlyInterestRate = $this->annualInterestRate/12;
    //     }


    //     $this->otherChargesInterest = 0.06; //6%
    //     $this->otherCharges = $this->principalAmount * $this->otherChargesInterest;
    //     $this->totalOtherCharges = number_format($this->otherCharges, 2, '.', ',');
    //     $this->netProceeds = $this->principalAmount - $this->otherCharges;
    //     $this->totalNetProceeds = number_format($this->netProceeds, 2, '.', ',');
    //     $this->monthlyPayment = $this->principalAmount * ($this->monthlyInterestRate * ((1 + $this->monthlyInterestRate) ** $this->monthlyInstallment)) / ((1 + $this->monthlyInterestRate) ** $this->monthlyInstallment - 1);
    //     $this->totalMonthlyPaymentRound = round($this->monthlyPayment,2);
    //     $this->totalMonthlyPayment = number_format($this->totalMonthlyPaymentRound, 2, '.', ',');

    //     $this->outstandingBalance = $this->principalAmount;

    //     for ($this->month = 1; $this->month <= $this->monthlyInstallment; $this->month++) {
    //         $this->interest = $this->outstandingBalance * $this->monthlyInterestRate;
    //         $this->principalPaid = $this->monthlyPayment - $this->interest;
    //         $this->Charges = $this->principalAmount * $this->otherChargesInterest;
    //         $this->netProceeds = -($this->principalPaid + $this->interest);
    //         $this->netP = $this->principalAmount - $this->Charges;
    //         // Update outstanding balance for the next iteration
    //         $this->outstandingBalance = $this->outstandingBalance - $this->principalPaid;
    //         // Store installment details in the array
    //         $this->installmentDetails[] = array(
    //             'month' => $this->month,
    //             'grossLoan' => number_format($this->principalAmount, 2, '.', ','),
    //             'principal' => number_format($this->principalPaid, 2, '.', ','),
    //             'interest' => number_format($this->interest, 2, '.', ','),
    //             'netProceeds' => number_format($this->netProceeds, 2, '.', ','),
    //             'outstandingBalance' => number_format($this->outstandingBalance, 2, '.', ','),
    //         );
    //     }

    //     dd($this->installmentDetails);

    // }

}; ?>

<div>


 
    <livewire:components.loan-calculator-component />

    {{-- <x-form wire:submit.prevent="compute">
        <x-input label="Principal Amount" wire:model.defer="principalAmount" prefix="PHP" money hint="It submits an unmasked value" />
        <x-select label="Terms" :options="$terms" wire:model="termsYears" placeholder="Select Terms"/>
        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>


    Principal Amount {{ $totalprincipalAmount }} <br>
    No of Installments: {{ $monthlyInstallment }} <br><br>

     Other Charges:  {{$totalOtherCharges}} <br>


     Annual Interest Rate: {{$annualInterestRate}} <br>
     Monthly Interest Rate: {{$monthlyInterestRate}}
 --}}




</div>
