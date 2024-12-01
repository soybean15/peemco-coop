<?php

use Livewire\Volt\Component;
use App\Models\Loan;

new class extends Component {

    public $loan;
    public function mount(Loan $loan){

        $this->loan = $loan;
    }

}; ?>

<div>

    <x-bread-crumbs :routes="[
        ['label'=>'Loan Details','name'=>'admin.pending'],
        ['label'=>$this->loan->loan_application_no],


    ]" />

    @if($this->loan->loanType->type =='regular')

    <livewire:components.loan-profile :loan='$loan'/>

    @elseif($this->loan->loanType->type =='flexible')
    <livewire:components.loan-profile-flexible :loan='$loan'/>

    @else
    <livewire:components.loan-profile-cash-advance :loan='$loan'/>
    @endif
</div>


