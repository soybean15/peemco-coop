<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\LoanItem;
use App\Models\CashAdvanceItem;

use App\Models\Loan;
use App\Actions\Payment\CashAdvancePayment;
use App\Actions\Payment\LoanPayment;
use App\Services\Loans\PaymentService;
use App\Actions\Payment;
use Mary\Traits\Toast;
use Illuminate\Support\Carbon;

new class extends Component {


    use Toast;
    public $modal = false;

    public $loanItem;

    public $or_cdv;
    public $amount;

    public $date;

    public $loanType;

    public $loan;

    public $type;
    #[On('add-payment')]
    public function onAddPayment($loanItemId){
        // dd('hjer');
        $this->loanItem = LoanItem::find($loanItemId);
        // dd($this->loanItem);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->amount = $this->loanItem->running_balance;
        $this->modal =true;
        $this->type= 'regular';

    }


    #[On('add-flexible-payment')]
    public function onAddFlexiblePayment($loanId){
        // dd('hjer');
        $this->loan = Loan::find($loanId);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->amount =0;
        $this->type= 'flexible';
        $this->modal =true;

    }

    #[On('add-cash-advance-payment')]
    public function onAddCashAdvancePayment($loanId){
        // dd('hjer');
        $this->loanItem = CashAdvanceItem::find($loanId);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->amount =$this->loanItem->amount_to_pay + $this->loanItem->penalty;
        $this->modal =true;
        $this->type= 'cash_advance';


    }

    public function submit(){
        $this->validate(
            [
                'date'=>'required|date',
                'amount'=>'required|numeric|min:1',
                'or_cdv'=>'required'
                ]
        );
        try{

            $action = match($this->type){
                'regular'=>new LoanPayment,
                'cash_advance'=>new CashAdvancePayment,
                default =>new LoanPayment
            };

            // dd($action);

            (new PaymentService($action))->handle([
                'amount'=>$this->amount,
                'or_cdv'=>$this->or_cdv,
                'date'=>$this->date,
                'loan_item'=>$this->loanItem,
                'loan'=>$this->loan
            ]);

            $this->dispatch('refresh-page');

            $this->modal=false;
            $this->success('Payment Sucessfull');
        }catch (\Exception $e){

            dd($e);
        }
    }
}; ?>

<div>
    <x-modal wire:model="modal" title="Add Payment" subtitle="{{ $loanItem?->loan->loan_application_no }}" separator >

        <x-form  wire:confirm='Continue Payment' wire:submit="submit">
            <x-datetime label="Date" wire:model="date" icon="o-calendar" />
            <x-input label="OR CDV" wire:model.live="or_cdv"  />
            <x-input label="Amount to pay" wire:model="amount" prefix="PHP" type="number" step="0.01"/>


            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modal = false" />
                <x-button label="Proceed payment" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>



    </x-modal>
</div>
