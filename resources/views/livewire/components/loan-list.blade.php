<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\Loan;

new class extends Component {
    use WithPagination;
    public $search;
    public $renderFrom;
    public function mount($renderFrom){
        // dd($this->renderFrom);
        $this->renderFrom = $renderFrom;
    }
    public function with(){
        return [

            'headers'=>[
                ['key'=>'loan_application_no' ,'label'=>'Loan Number'],
                ['key'=>'user_id' ,'label'=>'Member Name'],
                ['key'=>'date_applied' ,'label'=>'Date Applied'],
                ['key'=>'loan_type' ,'label'=>'Loan Type'],

                ['key'=>'principal_amount' ,'label'=>'Principal Amount'],
                ['key'=>'no_of_installment' ,'label'=>'Number of periods'],
                ['key'=>'monthly_interest_rate' ,'label'=>'Monthly Rate'],
                ['key'=>'monthly_payment' ,'label'=>'Monthly Payment'],
                ['key'=>'status' ,'label'=>'Status'],
            ],'loans'=>Loan::retrieve($this->renderFrom)
                ->where('loan_application_no', 'LIKE', "%$this->search%")
                ->paginate(5)
            ];
    }
}; ?>

<div>


    <x-header title="" subtitle="">
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
        </x-slot:actions>
    </x-header>


    <x-table :headers="$headers" :rows="$loans" with-pagination>
        {{-- Overrides `name` header --}}
        @scope('cell_loan_application_no', $loan)

        @php

            $route = 'admin.loan-profile';
            if($this->renderFrom =='user'){

                $route = 'user.loan-profile';
            }
        @endphp

        <a class="text-info hover:underline " href="{{ route($route,['loan'=>$loan]) }}"><strong>{{ $loan->loan_application_no }}</strong></a>



        @endscope
        @scope('cell_user_id', $loan)
        <i>{{ $loan->user->name }}</i>
        @endscope
        {{-- Overrides `city.name` header --}}
        @scope('cell_date_applied', $loan)
        <i>{{ $loan->date_applied  }}</i>
        @endscope
        @scope('cell_principal_amount', $loan)
        <i>{{ $loan->principal_amount ??'N/A' }}</i>
        @endscope
        @scope('cell_terms_of_loan', $loan)
        <i>{{ $loan->terms_of_loan ??'N/A' }}</i>
        @endscope
        @scope('cell_no_of_installment', $loan)
        <i>{{ $loan->no_of_installment ??'N/A' }}</i>
        @endscope
        @scope('cell_monthly_interest_rate', $loan)
        <i>{{ $loan->monthly_interest_rate??'N/A' }}</i>
        @endscope
        @scope('cell_monthly_payment', $loan)
        <i>{{ $loan->monthly_payment??'N/A'  }}</i>
        @endscope
        @scope('cell_status', $loan)
        <i>{{ $loan->status??'N/A'  }}</i>
        @endscope

    </x-table>
</div>
