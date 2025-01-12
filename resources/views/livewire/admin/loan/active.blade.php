<?php
use Livewire\Volt\Component;
use App\Models\Loan;
use Livewire\WithPagination;
use App\Enums\LoanStatuEnum;
use Illuminate\View\View;

new class extends Component {

    public function rendering(View $view): void
    {
        $view->title('Admin - Active Loans');


    }
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
