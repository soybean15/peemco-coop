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

    <livewire:components.loan-profile :loan='$loan'/>
</div>


