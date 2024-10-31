<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
new class extends Component {


    public function with(){
return [
        'loanTypes'=>LoanType::all(),
        'headers'=>[

            [ 'key'=>'loan_type', 'label'=>'Loan Type'],
            [ 'key'=>'type', 'label'=>'Type'],
            [ 'key'=>'charges', 'label'=>'Charges'],
        ]
    ];
    }

}; ?>

<div>
    <x-header title="Loan Types">

        <x-slot:actions>

            <x-button icon="o-plus" label="Add" class="btn-primary" link="{{ route('admin.add-loan-type') }}" />
        </x-slot:actions>
    </x-header>
    <x-table :headers="$headers" :rows="$loanTypes" no-headers no-hover />
</div>
