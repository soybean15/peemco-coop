<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;
    public $search;

    public function with(){


        return [

        'loans'=>auth()->user()->loans()
        ->search($this->search)
        ->paginate(5),
        'headers'=>[

            ['key'=>'loan_application_no' ,'label'=>'Loan Number'],
            ['key'=>'date_applied' ,'label'=>'Date Applied'],
            ['key'=>'principal_amount' ,'label'=>'Principal Amount'],
            ['key'=>'terms_of_loan' ,'label'=>'Terms of loan'],
            ['key'=>'monthly_interest_rate' ,'label'=>'Monthly Rate'],
            ['key'=>'monthly_payment' ,'label'=>'Monthly Payment'],
            ['key'=>'status' ,'label'=>'Status'],
        ]
    ];
    }
}; ?>

<div>

    <x-header title="Loans" separator >
        <x-slot:middle class="!justify-end">
            <x-input icon="o-bolt" placeholder="Search..." wire:model.live='search' />
        </x-slot:middle>
        <x-slot:actions>


        <x-button class="btn-success" label='Add Loan' link="{{ route('user.loan-calculator') }}" />

    </x-slot:actions>
    </x-header>

    <x-table :headers="$headers" :rows="$loans"

     with-pagination>
        {{-- Overrides `name` header --}}
        @scope('cell_loan_application_no', $loan)
        <strong>{{ $loan->loan_application_no }}</strong>
        @endscope
        {{-- Overrides `city.name` header --}}
        @scope('cell_date_applied', $loan)
        <i>{{ $loan->date_applied }}</i>
        @endscope
        @scope('cell_principal_amount', $loan)
        <i>{{ $loan->principal_amount }}</i>
        @endscope
        @scope('cell_terms_of_loan', $loan)
        <i>{{ $loan->terms_of_loan }}</i>
        @endscope
        @scope('cell_monthly_interest_rate', $loan)
        <i>{{ $loan->monthly_interest_rate }}</i>
        @endscope
        @scope('cell_monthly_payment', $loan)
        <i>{{ $loan->monthly_payment }}</i>
        @endscope
        @scope('cell_status', $loan)
        <i>{{ $loan->status }}</i>
        @endscope
    </x-table>
</div>
