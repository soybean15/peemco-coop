<?php

use Livewire\Volt\Component;
use App\Services\LoanCalculator\LoanCalculator;

use App\Models\LoanType;
use App\Models\User;

new class extends Component {


    public $loanType;
    public $user_searchable_id;
    public $selectedOption;
    public $user_id;
    public $users;


    public $amount;
    public function mount(LoanType $cashAdvance){
        $this->loanType = $cashAdvance;
        $this->amount = $this->loanType->minimum_amount;

        $this->search();
    }

    public function search(string $value = '')
    {

        try{
                // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->user_id)->get();

        $this->users =   app(LoanCalculator::class)
        ->setLoanType($this->loanType->id)

        ->getUsers($value)
        ->orderBy('name')
        ->get()
        ->merge($selectedOption);
// $this->users = User::query()
//     ->search($value)
//     ->take(5)
//     ->orderBy('name')
//     ->get()
//     ->merge($selectedOption);
        }catch(\Exception $e){
            dd($e);
        }

    }
}; ?>

<div>
    <x-header title="{{ $loanType->loan_type }}"  separator />

    <div class="grid grid-cols-2 gap-4 ">

        <div class="p-5 space-y-2 border">
            <x-header title="Cash advance details" size="text-xl" separator />
            <x-choices
                label="Select User"
                wire:model="user_searchable_id"
                :options="$users"
                placeholder="Search ..."
                single
                searchable />

            <div class="grid grid-cols-2 gap-3">
                <x-input label="Cash amount"  wire:model='amount' placeholder="Cash advance Amount" readonly  type="number"/>

            </div>
            <div class="p-6 mt-auto border-t border-gray-200">

                <x-button label="Apply" class="w-full text-base-100 btn btn-success" />
            </div>
        </div>


        <div class="p-5 border">
            <x-header title="Loan Details" size="text-xl" separator />

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Amount</span>
                    <span class="font-bold text-md">₱{{ $this->amount ?? 0 }}</span>

                </div>
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Charge</span>
                    <span class="font-bold text-md">{{ $this->loanType->charges ?? 0 }}%</span>

                </div>
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Charge Amount</span>
                    <span class="font-bold text-md">₱{{ $this->loanType->charge_amount ?? 0 }}</span>

                </div>

                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Penalty</span>
                    <span class="font-bold text-md">{{ $this->loanType->penalty ?? 0 }}%</span>

                </div>
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Grace period</span>
                    <span class="font-bold text-md">{{ $this->loanType->grace_period ?? 0 }}</span>

                </div>



            </div>
        </div>

    </div>
</div>
