<?php

use Livewire\Volt\Component;
use App\Models\Loan;

new class extends Component {

    public $loan;

    public function mount(Loan $loan){
        $this->loan;

    }
}; ?>

<div>
    <x-header title="Loan Details"  separator />

    <div>

        <x-stat
        title="Member"
        description="{{ $this->loan->user->name }}"

        />

        <x-stat
        title="Loan Amount"
        description="{{ $this->loan->loan_amount }}"

        />
    </div>



</div>
