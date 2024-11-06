<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use App\Actions\Loan\LoanApproval;
use App\Actions\Loan\LoanRejection;

use Mary\Traits\Toast;
use App\Services\Loans\LoanService;
use App\Services\LoanPayment\LoanPaymentService;
new class extends Component {
    use Toast;
    public $loan;

    public $loanItems;
    public $headers;

    public function mount(Loan $loan){
        $this->loan=$loan;
        $this->loanItems = $loan->items;
        $this->headers = [

                    ['key' => 'loan_period', 'label' => 'Period'],
                    ['key' => 'due_date', 'label' => 'Due Date'],
                    ['key' => 'amount_due', 'label' => 'Amount Due'],
                    ['key' => 'amount_paid', 'label' => 'Amount Paid'],
                    ['key' => 'past_due', 'label' => 'Past Due'],
                    ['key' => 'running_balance', 'label' => 'Running Balance'],
                    ['key' => 'status', 'label' => 'Status'],
        ];

        (new LoanPaymentService($loan))->handle();
    }


    // public function with(){
    //     // return [

    //     //     'loanItem'->$this->loan->items,
    //     //     'headers'=>[

    //     //             ['key' => 'loan_period', 'label' => 'Period'],
    //     //             ['key' => 'amount_due', 'label' => 'Amount Due'],
    //     //             ['key' => 'past_due', 'label' => 'Past Due'],
    //     //             ['key' => 'running_balance', 'label' => 'Running Balance'],

    //     //     ]
    //     // ];
    // }

    public function approveLoan(){
        try{
          (new LoanService(new LoanApproval()))->handle(
            [
                'loan'=>$this->loan
            ]
          );

          $this->success('Loan Approved');
        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }
    public function rejectLoan(){
        try{
          (new LoanService(new LoanRejection()))->handle(
            [
                'loan'=>$this->loan
            ]
          );

          $this->success('Loan Rejected');
        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }
}; ?>

<div>

    <x-header title="Loan Details"  separator >

        <x-slot:actions>

        @if($loan->status=='pending')
        <x-button class="btn-success" label='Approve' wire:confirm='Are you sure you want to approve this loan?'
            wire:click='approveLoan' />
        <x-button class="btn-error" label='Reject' wire:confirm='Are you sure you want to reject this loan?'
            wire:click='rejectLoan' />

        @else

            @if($this->loan->status =='rejected')
            <x-icon name="o-x-mark" class="text-2xl text-red-500 w-9 h-9" label="{{  $this->loan->status }}" />

            @else

            <x-icon name="o-check" class="text-2xl text-green-500 w-9 h-9" label="{{  $this->loan->status }}" />

            @endif



        @endif

    </x-slot:actions>

    </x-header>

    <div class="grid grid-cols-4">


        <x-stat
        title="Loan Number"
        value="{{ $this->loan->loan_application_no  }}"
        />
        <x-stat
        title="Member"
        value="{{ $this->loan->user->name  }}"


        />

        <x-stat
        title="Loan Amount"
        value="{{ number_format($this->loan->principal_amount ,2)}}"
        />
        <x-stat
        title="Monthly Payment"
        value="{{ number_format($this->loan->monthly_payment ,2)}}"
        description='Rate: {{ $this->loan->monthly_interest_rate }}'
        />



    </div>


    <x-table :headers="$headers" :rows="$loanItems" >
        @scope('cell_status', $loan)
            @if($loan->status=='to pay')
            <x-badge :value="$loan->status" class="badge-info" />

            @elseif($loan->status=='overdue')
            <x-badge :value="$loan->status" class="badge-error" />

            @else
            <x-badge :value="$loan->status" class="badge-warning" />

            @endif
        @endscope
    </x-table>



</div>
