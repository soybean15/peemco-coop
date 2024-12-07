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
        ['label'=>'Select Loan','name'=>'admin.loan-application'],
        ['label'=>'Cash Advance','name'=>'admin.loan-cash-advance'],
        ['label'=>$loanType->loan_type,]

    ]" />
    <livewire:components.apply-cash-advance :loanType="$loanType" renderFrom='admin'/>
</div>
