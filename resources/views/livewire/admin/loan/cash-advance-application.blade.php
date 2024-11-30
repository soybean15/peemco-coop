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

    <livewire:components.apply-cash-advance :loanType="$loanType" renderFrom='admin'/>
</div>
