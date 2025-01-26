<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
use  App\Services\LoanType\LoanTypeService;
use App\Models\User;

new class extends Component {

    public $loanType;
    public $users;
    public $step;
    public $user_ids=[];


    public function mount(LoanType $loanType){

        $this->loanType =$loanType;
        // dd($loanType);
        $this->search();

    }


    public function search($value =null){
        $service = new LoanTypeService($this->loanType);

        $selectedOption = User::where('id', $this->user_ids)->get();
        $this->users= $service->getUsersExcept()
        ->search($value)->take(5)->get()->merge($selectedOption);
    }


    public function addUsers(){

        $service = new LoanTypeService($this->loanType);

        $service->addUsers($this->user_ids);
        $this->user_ids= [];
        $this->search();
        $this->loanTypeUsers = $this->loanType->loanTypeUsers;
        $this->dispatch('refresh-page');
    }
}; ?>

<div>
    <div class="grid grid-cols-1 md:grid-cols-2">


    <livewire:admin.loan-type.loan-type-form :loanTypeId='$loanType->id'/>

    <div>

        <div class="grid grid-cols-1 md:grid-cols-2 ">
            <div class="flex flex-col">
                <x-choices
                label="Add Users"
                wire:model.live="user_ids"
                :options="$users"
                search-function="search"
                placeholder="Search ..."
                searchable
    
                />
                @if(count($user_ids)>0)
                <x-button label="Add" class="my-3 btn-success btn-sm" wire:click='addUsers' />
    
                @endif
            </div>
    
        </div>
        <livewire:admin.loan-type.loan-type-user-list :loanType="$loanType"/>
    
    </div>



    </div>
</div>
