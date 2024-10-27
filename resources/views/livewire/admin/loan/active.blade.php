<?php
use Livewire\Volt\Component;
use App\Models\Loan;
use Livewire\WithPagination;
use App\Enums\LoanStatuEnum;
new class extends Component {
    public function with(){

        return [
            'renderFrom'=> LoanStatuEnum::ACTIVE->value
        ];
}
}; ?>

<div>
    <x-header title="Active Loans" subtitle="Active Loans" separator />
    <livewire:components.loan-list :renderFrom='$renderFrom'/>
</div>
