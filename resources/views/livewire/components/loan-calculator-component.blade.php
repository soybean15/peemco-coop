<?php

use Livewire\Volt\Component;

use App\Services\LoanCalculator\LoanCalculator;
use App\Services\LoanCalculator\LoanItem;
use App\Actions\Loan\LoanApplication;
use App\Services\Loans\LoanService;
use Mary\Traits\Toast;

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
    public function mount(){




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

        // $monthly_rate = $data['monthly_rate'];
        // $annual_rate = $data['annual_rate'];
        // $principal = $data['principal'];
        // $user_id = $data['user_id'];
        // $no_of_installment = $data['no_of_installment'];
        // $terms_of_loan = $data['terms_of_loan'];
        // $other_charges = $data['other_charges'] ?? 0;  // Default to 0 if not provided

        try{
          (new LoanService(new LoanApplication()))->handle(
            [
                'monthly_rate'=>$this->monthly_rate,
                'annual_rate'=>$this->annual_rate,
                'principal'=>$this->principal,
                'user_id'=>auth()->user()->id,
                'no_of_installment'=>$this->number_of_installment,
                'terms_of_loan'=>$this->terms,
                'other_charges'=>$this->other_charges
            ]
          );

          $this->success('Loan Application Successful');
        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }

}; ?>

<div>


    <x-header title="Loan Calculator" separator>
        <x-slot:actions>

            @if(auth()->user()->hasRole('Member'))
            <x-button class="btn-success" label='Apply Loan' wire:confirm='Are you sure you want to apply this loan?'
                wire:click='applyLoan' />
            @endif
        </x-slot:actions>
    </x-header>
    <div class="grid grid-cols-1 my-5 md:grid-cols-3 ">
        <x-form wire:submit.prevent="compute">
            <x-input label="Principal Amount" wire:model.defer="principal" prefix="PHP" money
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
            <x-slot:actions>
                <x-button label="Cancel" class="btn-sm" />
                <x-button label="Compute" class="btn-primary btn-sm" type="compute" spinner="compute" />
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
            {{--
            <x-input label="Principal" value="{{ $principal }}" disabled />
            <x-input label="Terms Of Loans in Years" value="{{ $terms }}" disabled />
            <x-input label="Number Of Installment" value="{{ $number_of_installment }}" disabled />
            <x-input label="Other Charges" value="It is disabled" disabled />
            <x-input label="Annual Rate" value="{{ $annual_rate }}" disabled />
            <x-input label="Monthly Rate" value="{{ $monthly_rate }}" disabled />
            <x-input label="Monthly Payment" value="{{ $monthly_payment }}" disabled /> --}}



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
