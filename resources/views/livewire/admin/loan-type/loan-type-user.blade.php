<?php

use Livewire\Volt\Component;
use  App\Services\LoanType\LoanTypeService;
use Livewire\Attributes\On;
use App\Models\LoanType;
use App\Models\LoanTypeUser;

use App\Models\User;

new class extends Component {

    public $loanTypeUsers ;
    public $loanType;
    public $step=1;

    public $users;
    public $user_ids=[];

    public $applyTo;
    public function mount(){
        $loan_type_id = session('loan_type_id');
        // dd($loan_type_id);
        $this->loanType = LoanType::find($loan_type_id);
        $this->search();
    }
    public function updatedApplyTo(){
        if($this->loanType){
            $this->loanType->update(['apply_to'=>$this->applyTo]);
        }
    }


    #[On('submit-loan-type-details')]
    public function submitDetails(){

        $this->dispatch('move-next-step');

    }

    #[On('move-next-step')]
    public function onMove(){


        $loan_type_id = session('loan_type_id');
        // dd($loan_type_id);
        $this->loanType = LoanType::find($loan_type_id);

        $this->search();

        $this->applyTo = $this->loanType->apply_to;
        if($this->loanType){

            $this->loanTypeUsers = $this->loanType->loanTypeUsers;

        }

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
    <x-header title="Add Users" separator />
    <x-card title="Apply To" subtitle="Select users" separator progress-indicator>


        <div class="flex items-center mb-4">
            <input id="default-radio-1" type="radio" value="all"  wire:model.live='applyTo' name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-radio-1" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">All</label>
        </div>
        <div class="flex items-center">
            <input  id="default-radio-2" type="radio" value="selected"  wire:model.live='applyTo' name="default-radio" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
            <label for="default-radio-2" class="text-sm font-medium text-gray-900 ms-2 dark:text-gray-300">Selected</label>
        </div>

    </x-card>


    @if($this->loanType && $this->loanType->apply_to =='selected')
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
    @endif


    <div x-data x-on:refresh-page.window='$wire.$refresh()'>

        <livewire:admin.loan-type.loan-type-user-list :loanType="$loanType"/>


    </div>

</div>
