<?php
use App\Models\LoanType;

use Livewire\Volt\Component;
use App\Models\LoanTypeUser;
use Livewire\Attributes\On;
new class extends Component {

    public $loanTypeUsers;
    public $loanType;
    public function mount($loanType){

        $this->loanType=$loanType;
        if($this->loanType){

            $this->loanTypeUsers = $this->loanType->loanTypeUsers;

        }
    }

    #[On('refresh-page')]
    public function onRefresh(){
        if($this->loanType){

            $this->loanTypeUsers = $this->loanType->loanTypeUsers;

        }
    }

            #[On('move-next-step')]
            public function onMove(){



        $loan_type_id = session('loan_type_id');
        // dd($loan_type_id);
        $this->loanType = LoanType::find($loan_type_id);


        $this->applyTo = $this->loanType->apply_to ??'all';

        $this->loanType->update(['apply_to'=>$this->applyTo]);
     
        if($this->loanType){

            $this->loanTypeUsers = $this->loanType->loanTypeUsers;

        }

        }



    public function remove(LoanTypeUser $user){

        $user->delete();
        $this->loanTypeUsers = $this->loanType->loanTypeUsers;
        $this->dispatch('refresh-page');
    }


}; ?>

<div>


    @if($loanType && $loanType->apply_to=='selected')


    @php
    $headers = [
    ['key' => 'id', 'label' => '#'],
    ['key' => 'name', 'label' => 'Name'],
    ['key' => 'email', 'label' => 'Email'],
    ['key' => 'action', 'label' => 'Action'],
    ]
    @endphp

    <div>

        <strong class="text-lg">Users</strong>
    </div>


    <div x-data x-on:refresh-page.window='$wire.$refresh()'>

        <x-table :headers="$headers" :rows="$loanTypeUsers" show-empty-text empty-text="No users found!">
            @scope('cell_name',$loanTypeUser)

            {{ $loanTypeUser->user->name }}
            @endscope
            @scope('cell_email',$loanTypeUser)
            {{ $loanTypeUser->user->email }}
            @endscope
            @scope('cell_action',$loanTypeUser)

            <x-button icon="o-trash" class="btn-circle btn-error"
                wire:confirm='Are you sure you want the delete this user?' wire:click='remove({{ $loanTypeUser }})' />
            @endscope
        </x-table>
    </div>
    @endif

</div>
