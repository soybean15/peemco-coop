<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use Livewire\WithPagination;
use App\Enums\LoanStatuEnum;

new class extends Component {
    use WithPagination;
    public function with(){


        return [


            'renderFrom'=> LoanStatuEnum::COMPLETED->value
        ];

    }
}; ?>

<div>
    <x-header title="Completed Loans" subtitle="Completed Loans" separator />

    <livewire:components.loan-list :renderFrom='$renderFrom'/>
</div>
