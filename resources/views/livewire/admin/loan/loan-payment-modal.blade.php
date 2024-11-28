<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\LoanItem;
use App\Models\Loan;

use App\Services\Loans\LoanService;
use App\Actions\Loan\LoanPayment;
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

    #[On('add-payment')]
    public function onAddPayment($loanItemId){
        // dd('hjer');
        $this->loanItem = LoanItem::find($loanItemId);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->amount = $this->loanItem->total_amount_due;
        $this->modal =true;

    }


    #[On('add-flexible-payment')]
    public function onAddFlexiblePayment($loanId){
        // dd('hjer');
        $this->loan = Loan::find($loanId);
        $this->date = Carbon::now()->format('Y-m-d');
        $this->amount =0;
        $this->modal =true;

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

            (new LoanService(new LoanPayment))->handle([
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
            <x-input label="Amount to pay" wire:model.live="amount" prefix="PHP" money />

            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modal = false" />
                <x-button label="Proceed payment" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>



    </x-modal>
</div>
