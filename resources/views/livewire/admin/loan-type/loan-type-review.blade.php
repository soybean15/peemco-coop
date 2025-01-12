<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\LoanType;

new class extends Component {

    public $loanTypeUsers;
    public $loanType;

    public function mount(){
        $loan_type_id = session('loan_type_id');
        // dd($loan_type_id);
        $this->loanType = LoanType::find($loan_type_id);


        if($this->loanType){
            $this->applyTo = $this->loanType->apply_to;
            $this->loanTypeUsers = $this->loanType->loanTypeUsers;

        }
    }
    #[On('move-next-step')]
    public function onMove(){


        $loan_type_id = session('loan_type_id');
        // dd($loan_type_id);
        $this->loanType = LoanType::find($loan_type_id);




        if($this->loanType){
            $this->applyTo = $this->loanType->apply_to;
            $this->loanTypeUsers = $this->loanType->loanTypeUsers;

        }

    }

    #[On('submit-loan-type-complete')]
    public function completeDetails(){

        $this->loanType->touch('completed_at');
        session()->forget('loan_type_id');

        return redirect()->to(route('admin.loan-type'));

    }
}; ?>

<div>
    <x-header title="Review Input" separator />


    @if($loanType)

    <div class="grid grid-cols-1 space-y-2 md:grid-cols-2">
        <div>
            <strong>Loan Type</strong>

            <div>{{ $loanType->loan_type }}</div>
        </div>
        <div>
            <strong>Type</strong>

            <div>{{ $loanType->type }}</div>
        </div>
        <div>
            <strong>Annual rate</strong>

            <div>{{ $loanType->annual_rate }}%</div>
        </div>
        <div>
            <strong>Charges</strong>

            <div>{{ $loanType->charges }}%</div>
        </div>
        <div>
            <strong>Maximum Amount</strong>

            <div>{{ $loanType->maximum_amount }}%</div>
        </div>
        <div>
            <strong>Minimum Amount</strong>

            <div>{{ $loanType->minimum_amount }}%</div>
        </div>
        <div>
            <strong>Penalty</strong>

            <div class='text-red-500'>{{ $loanType->penalty }}%</div>
        </div>
        <div>
            <strong>Grace Period</strong>

            <div class="">{{ $loanType->grace_period }}</div>
        </div>
    </div>
    <hr class="my-5"/>
    <div>


        <livewire:admin.loan-type.loan-type-user-list :loanType="$loanType"/>

    </div>
    @endif
</div>
