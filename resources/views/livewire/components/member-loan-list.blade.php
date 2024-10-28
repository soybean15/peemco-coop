<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Loan;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search;
    public $users;

    public function mount($user_id)
    {
        $this->users = $user_id;
    }

    public function with()
    {
        return
        [
            'loanHeaders'=>[
                ['key' => 'loan_application_no', 'label' => 'Loan Application', ],
                ['key' => 'status', 'label' => 'Status', ],
                ['key' => 'action', 'label' => 'Action', ],
                // Alternative approach
            ],
            'loans' => Loan::where('user_id',$this->users)
                ->where('loan_application_no', 'LIKE', "%$this->search%")
                ->paginate(1)
        ];
    }
}; ?>

<div>


    <x-header title="Loans" subtitle="List of loans" separator>
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
        </x-slot:actions>
    </x-header>

    <x-table :headers="$loanHeaders" :rows="$loans" striped with-pagination x-on:refresh-table.window='$wire.$refresh()'/>  
        @scope('cell_loan_application_no', $loans)
                {{ $loans->loan_application_no}}
        @endscope
        @scope('cell_status', $loans)
            {{ $loans->status}}
        @endscope
        @scope('cell_action', $loans)
            <x-button icon="o-pencil-square" class="btn-ghost" x-on:click=""/>
        @endscope

        <livewire:components.loan-payment-list/> 
    
</div>
