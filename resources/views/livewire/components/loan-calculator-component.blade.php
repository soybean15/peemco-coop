<?php

use Livewire\Volt\Component;

use App\Services\LoanCalculator\LoanCalculator;
use App\Services\LoanCalculator\LoanItem;
use App\Actions\Loan\LoanApplication;
use App\Actions\Loan\LoanApproval;
use App\Services\Loans\LoanService;
use Mary\Traits\Toast;
use App\Models\Loan;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Computed;
new class extends Component {
    use Toast,WithPagination;


    public $renderFrom;
    public $loanItems=[];
    public $terms;
    public $principal;
    public $other_charges;
    public $annual_rate;
    public $monthly_rate;
    public $monthly_payment;
    public $number_of_installment;

    public $charges;
    public $charges_amount;

    public $loanType;
    public $loanTypes=[];


    public $loan;
    public $user_id;
    public $users;
    public function mount($renderFrom=null){




        $loanService = app(LoanCalculator::class);

        $this->loanTypes = $loanService->getLoanTypes();

        $this->search();

    }




    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = User::where('id', $this->user_id)->get();

        $this->users =   app(LoanCalculator::class)
        ->setLoanType($this->loanType)
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
    }
    public function updatedLoanType(){

        $this->fetchData();

    }

    public function updatedTerms(){

        $this->fetchData();

    }
    public function fetchData(){
        $loanService = app(LoanCalculator::class)
        ->setLoanType($this->loanType)
        ->setPrincipal($this->principal)
        ->setTerms($this->terms);
        $this->annual_rate = $loanService->getAnnualRate();
        $this->monthly_rate =$loanService->getMonthlyRate();
        $this->charges = $loanService->getCharges();
        $this->charges_amount = $loanService->getChargesAmount();
    }
    public function compute(){

        $loanService = app(LoanCalculator::class);

        $this->validate(
            [
                'terms'=>'required',
                'principal'=>'required',
                'loanType'=>'required'
            ]
        );

        $this->loanItems =$loanService
        ->setLoanType($this->loanType)
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

        if(!$this->user_id ){

            $this->user_id = auth()->user()->id;
        }
        // dd($this->user_id);
        try{
          (new LoanService(new LoanApplication()))->handle(
            [
                'monthly_rate'=>$this->monthly_rate,
                'annual_rate'=>$this->annual_rate,
                'principal'=>$this->principal,
                'user_id'=>$this->user_id,
                'no_of_installment'=>$this->number_of_installment,
                'terms_of_loan'=>$this->terms,
                'loan_type'=>$this->loanType,
                'other_charges'=>$this->other_charges,
                'monthly_payment'=>$this->monthly_payment
            ]
          );

          $this->success('Loan Application Successful');

          return redirect()->to(route('admin.pending'));

        }catch(\Exception $e){

            $this->error($e->getMessage());
        }

    }



}; ?>

<div>


    <x-header title="Apply Loan" subtitle='Loan Calculator' separator>
        <x-slot:actions>



        @if(auth()->user()->can('process loan') || auth()->user()->can('apply loan'))
        <x-button class="btn-success" label='Apply Loan' wire:confirm='Are you sure you want to apply this loan?'
            wire:click='applyLoan' />
        @endif

        </x-slot:actions>
    </x-header>
    <div class="grid grid-cols-1  my-5  md:grid-cols-2 max-w-[1300px] gap-3">


        <x-form wire:submit.prevent="compute" class="p-5 border ">

            <x-header title="Loan Details" subtitle="Enter your loan information" size="text-xl " separator class="mb-0 rounded-md" />

            <x-select label="Loan Type" :options="$this->loanTypes" wire:model.live="loanType"
                placeholder="Select Loan Type" />



            @can('process loan')

            <x-choices label="Member" wire:model="user_id" :options="$this->users" single searchable />

            @endcan




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
]" wire:model.live="terms" placeholder="Select Terms" />




            <x-slot:actions>
                @if(!$loan)

                {{--
                <x-button label="Cancel" class="btn-sm" /> --}}
                <x-button label="Compute" class="w-full btn-primary btn-sm" type="compute" spinner="compute" />

                @endif
            </x-slot:actions>
        </x-form>

        <div class="flex flex-col p-5 space-y-2 border">
            <x-header title="Loan Summary" subtitle="Loan Details" size="text-xl " separator class="mb-0 rounded-md" />

            <div class="grid grid-cols-1 gap-3 md:grid-cols-2">
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Principal</span>
                    <span class="font-bold text-md">₱{{ $this->principal ?? 0 }}</span>

                </div>

                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Terms Of Loans in Years</span>
                    <span class="font-bold text-md">{{ $terms ?? 0 }}</span>
                    {{-- <span>{{ $terms }}</span> --}}
                </div>

                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Number Of Installment</span>
                    <span class="font-bold text-md">{{ $number_of_installment ?? 0 }}</span>
                    {{-- <span>{{ $number_of_installment }}</span> --}}
                </div>

                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Annual Rate</span>
                    <span class="font-bold text-md">{{ $annual_rate ?? 0 }}%</span>
                    {{-- <span>{{ $annual_rate }}</span> --}}
                </div>

                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Monthly Rate</span>
                    <span class="font-bold text-md">{{ $monthly_rate ?? 0 }}%</span>
                    {{-- <span>{{ $monthly_rate }}</span> --}}
                </div>

                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Monthly Payment</span>
                    <span class="font-bold text-md">₱{{ $monthly_payment ?? 0 }}</span>
                    {{-- <span>{{ $monthly_payment }}</span> --}}
                </div>
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Charges</span>
                    <span class="font-bold text-md">{{ $charges ?? 0 }}%</span>
                    {{-- <span>{{ $monthly_payment }}</span> --}}
                </div>
                <div class="flex flex-col p-4 mt-2 bg-gray-100 rounded">

                    <span class="text-sm text-gray-500">Charges Amount</span>
                    <span class="font-bold text-md">₱{{ $charges_amount ?? 0 }}</span>
                    {{-- <span>{{ $monthly_payment }}</span> --}}
                </div>


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
