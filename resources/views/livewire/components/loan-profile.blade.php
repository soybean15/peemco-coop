<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use App\Actions\Loan\LoanApproval;
use App\Actions\Loan\LoanRejection;

use App\Helpers\PdfGenerator;
use Mary\Traits\Toast;
use App\Services\Loans\LoanService;
use App\Services\LoanPayment\LoanPaymentService;
use Spatie\LaravelPdf\Facades\Pdf;
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
                    ['key' => 'past_due', 'label' => 'Past Due'],
                    ['key' => 'total_due', 'label' => 'Total Due'],
                    ['key' => 'amount_paid', 'label' => 'Amount Paid'],
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

    public function print(){

        return (new PdfGenerator('invoices.salary-loan-application'))->stream();
        // Pdf::view('invoices.salary-loan-application')->save('invoice.pdf');

    }
}; ?>

<div>

    <div class="p-6 border rounded">
        <x-header title="Loan Details"  separator>

            <x-slot:actions>

                @if($loan->status=='pending')
                <x-icon name="o-clock" class="text-2xl text-warning w-9 h-9" label="{{  $this->loan->status }}" />
                @can('approve loan')
                <x-button class="btn-success" label='Approve' wire:confirm='Are you sure you want to approve this loan?'
                    wire:click='approveLoan' />
                <x-button class="btn-error" label='Reject' wire:confirm='Are you sure you want to reject this loan?'
                    wire:click='rejectLoan' />
                @endcan


                @else

                @if($this->loan->status =='rejected')
                <x-icon name="o-x-mark" class="text-2xl text-red-500 w-9 h-9" label="{{  $this->loan->status }}" />

                @else

                <div class="flex items-center space-x-5">
                    {{-- <x-icon name="o-check" class="text-2xl text-green-500 w-9 h-9" label="{{  $this->loan->status }}" /> --}}

                    <a href="{{ route('admin.generate-loan-application-pdf') }}" target="_blank"><x-icon name="o-printer" class="text-info" label="Print Loan Application" /></a>
                    {{-- <x-button label="Print Loan Application" icon='o-printer' class="mx-3 btn btn-sm btn-info" link="{{ route('admin.generate-loan-application-pdf') }}"> --}}
                </div>

                @endif



                @endif

            </x-slot:actions>

        </x-header>

        <div class="grid grid-cols-4">


            <x-stat title="Loan Number" value="{{ $this->loan->loan_application_no  }}" />
            <x-stat title="Member" value="{{ $this->loan->user->name  }}" />

            <x-stat title="Loan Amount" value="{{ number_format($this->loan->principal_amount ,2)}}" />
            <x-stat title="Monthly Payment" value="{{ number_format($this->loan->monthly_payment ,2)}}"
                description='Rate: {{ $this->loan->monthly_interest_rate }}' />



        </div>
    </div>


    <div class="p-5 mt-3 border">
        <x-header title="Payment Schedule"  size='text-xl' separator/>
    <x-table :headers="$headers" :rows="$loanItems" x-on:refresh-page.window="$wire.$refresh()" >

        @scope('cell_total_due', $loan)
        <div>

            <span>{{ $loan->total_due }} </span>
            @if($loan->penalty >0)
            <span class="text-red-500">({{ ($loan->penalty) }} )</span>
            @endif
        </div>

        @endscope
        @scope('cell_status', $loan)
        @if($loan->status=='to pay')
        <x-badge :value="$loan->status" class="badge-info" />

        <x-button x-on:click="$dispatch('add-payment',{loanItemId:{{ $loan->id }}})" icon="o-currency-dollar"
            class="btn-sm btn-info" />

        @elseif($loan->status=='overdue')
        <x-badge :value="$loan->status" class="badge-error" />
        @elseif($loan->status=='paid')
        <x-badge :value="$loan->status" class="badge-success" />

        @else
        <x-badge :value="$loan->status" class="badge-warning" />

        @endif
        @endscope
    </x-table>

    </div>

    <livewire:admin.loan.loan-payment-modal />


</div>
