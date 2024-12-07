<?php

use Livewire\Volt\Component;
use App\Models\LoanType;

new class extends Component {
    public $loanType;
    public function mount(LoanType $cashAdvance){
        $this->loanType = $cashAdvance;

    }
}; ?>

<div>
    <x-bread-crumbs :routes="[
        ['label'=>'Select Loan','name'=>'user.loan-application'],
        ['label'=>'Cash Advance','name'=>'user.loan-cash-advance'],
        ['label'=>$loanType->loan_type,]

    ]" />
    <livewire:components.apply-cash-advance :loanType="$loanType" renderFrom='user'/>
</div>
