<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use Livewire\WithPagination;
use App\Enums\LoanStatuEnum;
use Illuminate\View\View;

new class extends Component {
    use WithPagination;

    public function rendering(View $view): void
    {
        $view->title('Admin - Pending Loans');


    }
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
