<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\LoanItem;
use App\Services\Loans\LoanService;
use App\Actions\Loan\LoanPayment;
use Mary\Traits\Toast;
new class extends Component {


    use Toast;
    public $modal = false;

    public $loanItem;

    public $or_cdv;
    public $amount;


    #[On('add-payment')]
    public function onAddPayment($loanItemId){

        // dd('hjer');
        $this->loanItem = LoanItem::find($loanItemId);
        $this->amount = $this->loanItem->total_amount_due;
        $this->modal =true;

    }

    public function submit(){

        $this->validate(
            [
                'amount'=>'required|numeric|min:1',
                'or_cdv'=>'required'
                ]
        );

        try{

            (new LoanService(new LoanPayment))->handle([
                'amount'=>$this->amount,
                'or_cdv'=>$this->or_cdv,
                'loan_item'=>$this->loanItem
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
            <x-input label="OR CDV" wire:model.live="or_cdv"  />
            <x-input label="Amount to pay" wire:model.live="amount" prefix="PHP" money />

            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modal = false" />
                <x-button label="Proceed payment" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>



    </x-modal>
</div>
