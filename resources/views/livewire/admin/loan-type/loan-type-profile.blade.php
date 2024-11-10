<?php

use Livewire\Volt\Component;
use App\Models\LoanType;


new class extends Component {

    public $loanType;
    public $step;

    public function mount(LoanType $loanType){

        $this->loanType =$loanType;
        // dd($loanType);
    }

}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-2">


    <livewire:admin.loan-type.loan-type-form :loanTypeId='$loanType->id'/>

    </div>
</div>
