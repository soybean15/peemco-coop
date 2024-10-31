<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
use Mary\Traits\Toast;

new class extends Component {
    use Toast;


    public function with(){
return [
        'loanTypes'=>LoanType::all(),
        'headers'=>[

            [ 'key'=>'loan_type', 'label'=>'Loan Type'],
            [ 'key'=>'type', 'label'=>'Type'],
            [ 'key'=>'charges', 'label'=>'Charges'],
            [ 'key'=>'action', 'label'=>'Actions'],
        ]
    ];
    }

    public function deleteLoanType(LoanType $loanType){
        $loanType->delete();
        $this->error('Loan type archived');
    }

}; ?>

<div>
    <x-header title="Loan Types">

        <x-slot:actions>

        @can('add loan type')
            <x-button icon="o-plus" label="Add" class="btn-primary" link="{{ route('admin.add-loan-type') }}" />
        @endcan
        </x-slot:actions>
    </x-header>
    <x-table :headers="$headers" :rows="$loanTypes"  >
        @scope('cell_loan_type', $loanType)
        <a href="{{ route('admin.loan-type-profile',['loanType'=>$loanType->id]) }}">
            {{ $loanType->loan_type }}
        </a>

        @endscope
        @scope('cell_action', $loanType)

        <x-button icon='o-archive-box' class="btn-error btn-sm" wire:confirm='Are you sure you want to archive this loan type?' wire:click='deleteLoanType({{ $loanType->id }})'/>


        @endscope
    </x-table>
</div>
