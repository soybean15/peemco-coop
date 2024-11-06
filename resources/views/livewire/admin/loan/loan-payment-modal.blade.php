<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use App\Models\LoanItem;
use App\Services\Loans\LoanService;
use App\Actions\Loan\LoanPayment;
new class extends Component {


    public $modal = false;

    public $loanItem;


    public $form=[
        'amount'=>0
    ];


    #[On('add-payment')]
    public function onAddPayment($loanItemId){

        // dd('hjer');
        $this->loanItem = LoanItem::find($loanItemId);
        $this->form['amount'] = $this->loanItem->total_amount_due;
        $this->modal =true;

    }

    public function submit(){


        try{

            (new LoanService(new LoanPayment))->handle($this->form);
        }catch (\Exception $e){

        }
    }
}; ?>

<div>
    <x-modal wire:model="modal" title="Add Payment" subtitle="{{ $loanItem?->loan->loan_application_no }}" separator>

        <x-form wire:submit="save">

            <x-input label="Amount to pay" wire:model="form.amount" prefix="PHP" money />

            <x-slot:actions>
                <x-button label="Cancel" @click="$wire.modal = false" />
                <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>



    </x-modal>
</div>
