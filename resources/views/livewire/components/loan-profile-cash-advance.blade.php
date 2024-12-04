<?php

use Livewire\Volt\Component;
use App\Models\Loan;
use App\Services\LoanPayment\LoanPaymentService;

use App\Traits\Loans\LoanTrait;
new class extends Component {
    use LoanTrait;

    public $payments;
    public $items;
    public function mount(Loan $loan)
    {
        $this->headers = [

            ['key' => 'date', 'label' => 'Date'],
            ['key' => 'or_cdv', 'label' => 'OR CDV'],

            ['key' => 'added_by', 'label' => 'Added By',],
            ['key' => 'amount_paid', 'label' => 'Amount Paid','class'=>'font-bold'],
        ];

        $this->items = $loan->cashAdvanceItems()->latest()->get();
        // dd($this->item);

        $this->payments  = $loan->payments;
        (new LoanPaymentService($loan))->handle();
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


            <x-stat title="Loan Number" value="{{ $this->loan->loan_application_no  }}"    description="{{ ucfirst($this->loan->loanType->type) }}"/>
            <x-stat title="Member" value="{{ $this->loan->user->name  }}" />

            <x-stat title="Loan Amount" value="{{ number_format($this->loan->principal_amount ,2)}}" />


            <x-stat title="Total Payment" value="{{ number_format($this->loan->totalPayments ,2)}}"
                description='Charge amount : ₱{{ number_format(($this->loan->other_charges))}}' />



        </div>

        <div class="p-5 mt-3 border">

            @foreach ($items as $item)
            <x-header title="Payment Due Date" subtitle="{{ $item?->due_date??'' }}" size="text-lg" separator >
                <x-slot:actions>
                    <div class="flex items-center space-x-3">
                        <x-icon name="o-exclamation-circle" class="text-sm text-info" label="Charge Amount if not paid full: ₱{{  $item->charge_amount  }}"/>


                    {{-- {{ $item }} --}}
                    @if($item->status=='paid')

                    <x-badge value="Paid" class="p-2 text-lg badge-success" />
                    @else

                    <x-button icon="o-plus" x-on:click="$dispatch('add-cash-advance-payment',{loanId:{{ $item->id }}})" class="btn-primary btn-sm"  label="Add Payment"/>

                    @endif
                    </div>
                        {{-- <x-button icon="o-plus" class="btn-primary btn-sm" label="Payment"/> --}}
                </x-slot:actions>

            </x-header>

            <div>
                <div class="text-lg font-bold">Penalties</div>
                <div class="grid grid-cols-1 gap-1">
                    {{-- {{ $item->penalties }} --}}
                    @foreach ($item->penalties as $penalty)
                    <div class="flex items-center justify-between p-1 rounded-md bg-base-200">
                        <div>{{ $penalty->penalty_date_string }}</div>
                        {{-- <div>{{ $penalty->amount }}</div> --}}
                        <x-badge value="{{ $penalty->amount }}" class="badge-error" />
                    </div>
                    @endforeach

                    <div class="flex justify-end">
                        <div class="flex items-center">
                            <div>Total Penalty:</div>
                            <div class="font-bold">
                                ₱{{ $item->penalty }}
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            @endforeach


        </div>

{{--
        <div class="p-5 mt-3 border">
            <x-header title="Payment History"  size='text-xl' separator>
                <x-slot:actions>


                </x-slot:actions>

            </x-header>
            <x-table :headers="$headers"  :rows="$this->payments" striped  show-empty-text empty-text="No Payment yet!" >
                @scope('cell_added_by', $payment)

                   {{ $payment->addedBy->name}}
                @endscope
            </x-table>
        </div> --}}

    </div>

    <livewire:admin.loan.loan-payment-modal />
</div>
