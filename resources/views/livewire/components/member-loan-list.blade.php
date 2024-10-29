<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\Loan;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search;
    public $users;

    public $loanApplicationNo;
    public $user_id;
    public $isOpen = false;

    public function showModal($loanApplicationNo, $user_id)
    {
        $this->dispatch('openModal', $loanApplicationNo, $user_id);
    }
    public function closeModal()
    {
        $this->isOpen = false;
    }

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
                ->paginate(2)
        ];
    }
}; ?>

<div>


    <x-header title="Loans" subtitle="List of loans" separator>
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
        </x-slot:actions>
    </x-header>

    <div class="overflow-x-auto">
        <table class="table" with-pagination x-on:refresh-table.window='$wire.$refresh()'>
            <!-- head -->
            <thead>
            <tr>
    
                <th>Loan Application</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <!-- row 1 -->
             @foreach ($loans as $dataloan)
                <tr>
                    <th>{{$dataloan->loan_application_no}}</th>
                    <td>{{$dataloan->status}}</td>
                    <td>
                        <button class="btn" wire:click="showModal('{{$dataloan->loan_application_no}}', {{$dataloan->user_id}})">Paid Amotization</button>
                        <button class="btn btn-primary">Payment</button>
                    </td>
                </tr>
            @endforeach
          
            </tbody>
        </table>
        {{ $loans->links()}}
        </div>

       
        

        <livewire:components.paid-amotization/> 
    
</div>
