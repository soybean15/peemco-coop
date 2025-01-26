<?php

use Livewire\Volt\Component;
use App\Services\LoanCalculator\LoanCalculator;
use App\Actions\Loan\CashAdvanceApplication;
use App\Models\LoanType;
use App\Models\User;
use App\Services\Loans\LoanService;
use Mary\Traits\Toast;
new class extends Component {

    use Toast;

    public $loanType;
    public $user_searchable_id;
    public $selectedOption;
    public $user_id;
    public $users;

    public $renderFrom;

    public $amount;

    public $dateOptions=[];
    public $selectedLoanDate;


    public function mount(LoanType $loanType,$renderFrom=null){
        $this->loanType = $loanType;


        // dd($this->loanType);
        $this->amount = $this->loanType->minimum_amount;
        try{
            $this->dateOptions = $this->loanType->releaseDates->map(function ($item) {
                // Parse `from` and `to` as mm-dd and append the year
                $year = now()->year; // Use current year
                $fromDate = Carbon\Carbon::createFromFormat('m-d-Y', "{$item->from}-{$year}");
                $toDate = Carbon\Carbon::createFromFormat('m-d-Y', "{$item->to}-{$year}");

                // Format to desired output, e.g., "Jan 1, 2024 to Mar 2, 2024"
                $formattedDate = $fromDate->format('M j') . ' to ' . $toDate->format('M j');

                return [
                    'id' =>  $toDate->format('Y-m-d'),
                    'name' => $formattedDate,
                ];
            });
        }catch(\Exception $e){
            // dd($e);
        }

        $this->renderFrom = $renderFrom;
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

    public function apply(){


        try{


            if($this->renderFrom =='admin'){
                if (is_null($this->user_id)) {
                    throw new \Exception('Please select a member');
                }
            }else{
                $this->user_id = auth()->user()->id;
            }
            // dd($this->selectedLoanDate);
            (new LoanService(new CashAdvanceApplication()))->handle(
                    [

                        'principal'=>$this->amount,
                        'user_id'=>$this->user_id,
                        'loan_type_id'=>$this->loanType->id,
                        'charge_amount'=>$this->loanType->charge_amount,
                        'due_date'=>$this->selectedLoanDate
                        // 'monthly_payment'=>$this->monthly_payment
                    ]
            );

            $this->success('Loan Application Successful');

            if($this->renderFrom=='user'){
                return redirect()->to(route('user.loans'));

            }
            return redirect()->to(route('admin.pending'));

        }catch(\Exception $e){

         
            dd($e->getMessage());
                    $this->error($e->getMessage());
        }
    }
}; ?>

<div>

    <x-header title="{{ $loanType->loan_type }}" separator />

    <div class="grid grid-cols-2 gap-4 ">

        <div class="p-5 space-y-2 border">
            <x-header title="Cash advance details" size="text-xl" separator />



            @if($renderFrom=='user')
            <x-input label="Member" value="{{ auth()->user()->name }}" placeholder="Cash advance Amount" readonly/>
            @else
            <x-choices label="Select User" wire:model="user_id" :options="$users" placeholder="Search ..."
                single searchable />

            @endif

            <div class="grid grid-cols-2 gap-3">
                <x-input label="Cash amount" wire:model='amount' placeholder="Cash advance Amount" readonly
                    type="number" />

                    <x-select label="Loan Date" icon="o-user" :options="$dateOptions" wire:model="selectedLoanDate" placeholder="Select loan date" />

            </div>

            @can('apply loan')
            <div class="p-6 mt-auto border-t border-gray-200">

                <x-button label="Apply" class="w-full text-base-100 btn btn-success"   wire:confirm="Continue Cash advance application?" wire:click='apply' />
            </div>
            @endcan
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
