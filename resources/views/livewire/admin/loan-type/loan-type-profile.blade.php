<?php

use Livewire\Volt\Component;
use App\Models\LoanType;


new class extends Component {

    public $loanType;

    public function mount(LoanType $loanType){

        $this->loanType =$loanType;
        // dd($loanType);
    }

}; ?>

<div>
    <livewire:admin.loan-type.loan-type-form :loanTypeId='$loanType->id'/>

</div>
