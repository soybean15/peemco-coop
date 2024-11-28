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

    @if($this->loan->loanType->type =='regular')

    <livewire:components.loan-profile :loan='$loan'/>

    @else
    <livewire:components.loan-profile-flexible :loan='$loan'/>
    @endif
</div>


