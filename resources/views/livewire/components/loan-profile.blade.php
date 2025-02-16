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
use App\Models\LoanPenalty;
use App\Traits\Loans\LoanTrait;

new class extends Component {

    use LoanTrait;

    public $expanded=[];



    public function voidPenalty($penaltyId){
        $penalty = LoanPenalty::find($penaltyId);
    $penalty->update(['status'=>'void']);

    }
    // }
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

                    <a class="p-1 border rounded-md border-info"  href="{{ route('admin.generate-loan-application-pdf', ['loan' => $this->loan->id]) }}"
                        target="_blank"><x-icon name="o-printer" class="text-info" label="Loan Application" /></a>

                    <a class="p-1 border rounded-md border-primary" href="{{ route('admin.generate-loan-report-pdf', ['loan' => $this->loan->id]) }}"
                        target="_blank"><x-icon name="o-printer" class=" text-primary" label="Loan Report" /></a>
                    {{-- <x-button label="Print Loan Application" icon='o-printer' class="mx-3 btn btn-sm btn-info" link="{{ route('admin.generate-loan-application-pdf') }}"> --}}
                </div>

                @endif



                @endif

            </x-slot:actions>

        </x-header>

        <div class="grid grid-cols-4">


            <x-stat title="Loan Number" value="{{ $this->loan->loan_application_no  }}"    description="{{ ucfirst($this->loan->loanType->type) }}"/>
            <x-stat title="Member" value="{{ $this->loan->user->name  }}" />

            <x-stat title="Loan Amount" value="{{ number_format($this->loan->principal_amount ,2)}}" />
            <x-stat title="Monthly Payment" value="{{ number_format($this->loan->monthly_payment ,2)}}"
                description='Rate: {{ $this->loan->monthly_interest_rate }}' />



        </div>
    </div>


    <div class="p-5 mt-3 border">
    <x-header title="Payment Schedule"  size='text-xl' separator/>
    <x-table :headers="$headers" :rows="$loanItems" x-on:refresh-page.window="$wire.$refresh()" wire:model='expanded' expandable >

        @scope('cell_total_due', $loan)
        <div class="flex items-center">

            <span>{{ $loan->total_due }} </span>
            @if($loan->penalty >0)
            <span class="text-red-500">({{ ($loan->penalty) }} )</span>

            @endif


        </div>

        @endscope
        @scope('cell_status', $loan)
        @if($loan->status=='to pay' )
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


        @scope('expansion', $loan)
        <div class="0">

            @if( count($loan->penalties)>0)
            <strong>Penalties</strong>
            @foreach ($loan->penalties->whereNull('status') as $penalty )
                <x-list-item :item="$penalty" no-separator no-hover>
                    <x-slot:avatar>
                        <x-badge value="{{ $penalty->penalty_date }}" class="badge-error" />
                    </x-slot:avatar>
                    <x-slot:value>
                      Penalty amount: {{$penalty->amount}}
                    </x-slot:value>
                    <x-slot:sub-value>
                        Running balance:  {{$penalty->running_balance}}
                    </x-slot:sub-value>
                    <x-slot:actions>

                    <x-button label="Void" class="btn-error btn-sm" wire:confirm='Are you sure you want to void this penalty?' wire:click='voidPenalty({{$penalty->id}})' />

                    </x-slot:actions>
                </x-list-item>
            @endforeach

            {{-- <ul >
                @foreach ($loan->penalties as $penalty )
                <li class="flex space-x-3 ">

                    <span> {{ $penalty->penalty_date }}</span>
                    <span> {{ $penalty->amount }}</span>
                    <span> {{ $penalty->running_balance }}</span>
                </li>

                @endforeach
            </ul> --}}
        @endif

        </div>
        @endscope

    </x-table>

    </div>
    <livewire:components.payment-history :loan="$loan"/>

    <livewire:admin.loan.loan-payment-modal />


</div>
