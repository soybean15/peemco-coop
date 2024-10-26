<?php

use Livewire\Volt\Component;

use App\Services\LoanCalculator\LoanCalculator;
use App\Services\LoanCalculator\LoanItem;
use App\Actions\Loan\LoanApplication;
use App\Actions\Loan\LoanApproval;
use App\Services\Loans\LoanService;
use Mary\Traits\Toast;
use App\Models\Loan;

new class extends Component {
    use Toast;
    public $loanItems=[];
    public $terms;
    public $principal;
    public $other_charges;
    public $annual_rate;
    public $monthly_rate;
    public $monthly_payment;
    public $number_of_installment;

    public $loan;
    public function mount($loan =null){



        if($loan){
            $this->principal = $loan->principal_amount;
            $this->terms = $loan->terms_of_loan;

            $this->loan=$loan;
            $this->compute();
        }


    }
    public function compute(){
        $loanService = app(LoanCalculator::class);

        $this->validate(
            [
                'terms'=>'required',
                'principal'=>'required'
            ]
    );




        $this->loanItems =$loanService
        ->setPrincipal($this->principal)
        ->setTerms($this->terms)
        ->calculateLoan()
        ->getLoanItems();

        $this->monthly_rate =$loanService->getMonthlyRate();
        $this->annual_rate = $loanService->getAnnualRate();
        $this->monthly_payment = $loanService->getMonthlyPayment();
        $this->number_of_installment = $loanService->getNumberOfInstallment();
    }


    public function applyLoan(){
        try{
          (new LoanService(new LoanApplication()))->handle(
            [
                'monthly_rate'=>$this->monthly_rate,
                'annual_rate'=>$this->annual_rate,
                'principal'=>$this->principal,
                'user_id'=>auth()->user()->id,
                'no_of_installment'=>$this->number_of_installment,
                'terms_of_loan'=>$this->terms,
                'other_charges'=>$this->other_charges,
                'monthly_payment'=>$this->monthly_payment
            ]
          );

          $this->success('Loan Application Successful');

          return redirect()->to(route('user.loans'));

        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }

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


    <x-header title="Loan Calculator" separator>
        <x-slot:actions>


            @if($loan)

                @if($loan->status=='pending')
                <x-button class="btn-success" label='Approve' wire:confirm='Are you sure you want to approve this loan?'
                    wire:click='approveLoan' />
                <x-button class="btn-error" label='Reject' wire:confirm='Are you sure you want to reject this loan?'
                    wire:click='rejectLoan' />

                @endif

            @else

            <x-button class="btn-success" label='Apply Loan' wire:confirm='Are you sure you want to apply this loan?'
                wire:click='applyLoan' />
            @endif
        </x-slot:actions>
    </x-header>
    <div class="grid grid-cols-1 my-5 md:grid-cols-3 ">


        <x-form wire:submit.prevent="compute">



            @if($loan)
            <x-input label="Principal Amount" wire:model.live.debounce.250="principal" prefix="PHP" money
                hint="It submits an unmasked value" readonly />
            <x-select disabled label="Terms" :options=" [
            [
                'id' => 1,
                'name' => '1 Year'
            ],
            [
                'id' => 2,
                'name' => '2 Years',
            ],
            [
                'id' => 3,
                'name' => '3 Years',
            ],
            [
                'id' => 4,
                'name' => '4 Years',
            ],
            [
                'id' => 5,
                'name' => '5 Years',
            ]
        ]" wire:model="terms" placeholder="Select Terms" />


            @else

            <x-input label="Principal Amount" wire:model.live.debounce.250="principal" prefix="PHP" money
                hint="It submits an unmasked value" />
            <x-select label="Terms" :options=" [
    [
        'id' => 1,
        'name' => '1 Year'
    ],
    [
        'id' => 2,
        'name' => '2 Years',
    ],
    [
        'id' => 3,
        'name' => '3 Years',
    ],
    [
        'id' => 4,
        'name' => '4 Years',
    ],
    [
        'id' => 5,
        'name' => '5 Years',
    ]
]" wire:model="terms" placeholder="Select Terms" />

            @endif


            <x-slot:actions>
                @if(!$loan)

                <x-button label="Cancel" class="btn-sm" />
                <x-button label="Compute" class="btn-primary btn-sm" type="compute" spinner="compute" />

                @endif
            </x-slot:actions>
        </x-form>

        <div class="flex flex-col px-5 space-y-2">

            <div class="grid grid-cols-2">

                <span>Principal :</span>
                <span>{{ $principal }}</span>
            </div>
            <div class="grid grid-cols-2">

                <span>Terms Of Loans in Years :</span>
                <span>{{ $terms }}</span>
            </div>
            <div class="grid grid-cols-2">

                <span>Number Of Installment :</span>
                <span>{{ $number_of_installment }}</span>
            </div>
            <div class="grid grid-cols-2">

                <span>Annual Rate :</span>
                <span>{{ $annual_rate }}</span>
            </div>
            <div class="grid grid-cols-2">

                <span>Monthly Rate :</span>
                <span>{{ $monthly_rate }}</span>
            </div>
            <div class="grid grid-cols-2">

                <span>Monthly Payment :</span>
                <span>{{ $monthly_payment }}</span>
            </div>



        </div>

    </div>

    @php




    $headers =[
    ['key' => 'period', 'label' => 'Period'],
    ['key' => 'principal', 'label' => 'Principal'],
    ['key' => 'interest', 'label' => 'Interest'],
    ['key' => 'net_proceed', 'label' => 'Net Proceeds'],
    ['key' => 'balance', 'label' => 'Outstanding Balance'],


    ]

    @endphp


    <div class="overflow-x-auto">
        <table class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Period</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Net Proceed</th>
                    <th>Outstanding Balance</th>

                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->


                @foreach ($loanItems as $loanItem )

                <tr>
                    <td>
                        {{ $loanItem['period'] }}

                    </td>
                    <td> {{number_format($loanItem['principal'],2) }}</td>
                    <td> {{ number_format($loanItem['interest'] ,2)}}</td>

                    <td>{{ number_format($loanItem['net_proceed'],2) }}</td>
                    <td> {{ number_format($loanItem['balance'],2) }}</td>
                </tr>
                @endforeach


            </tbody>
        </table>
    </div>


</div>
