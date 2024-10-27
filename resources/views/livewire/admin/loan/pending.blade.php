<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use Livewire\WithPagination;
use App\Enums\LoanStatuEnum;

new class extends Component {
    use WithPagination;
    public function with(){
        return [
            'renderFrom'=> LoanStatuEnum::PENDING->value
        ];
    }
}; ?>

<div>

    <x-header title="Pending Loans" subtitle="Pending Loan Requet" separator />
    <livewire:components.loan-list :renderFrom='$renderFrom'/>

</div>
