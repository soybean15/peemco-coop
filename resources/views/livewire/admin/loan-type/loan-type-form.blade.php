<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
new class extends Component {


    public $loanType;
    public $type='regular';

    public $form=[
        'loan_type'=>null,
        'charges'=>null,
        'annual_rate'=>null,
        'minimum_amount'=>null,
        'maximum_amount'=>null,


        ];
    public $types = [
       [ 'id'=>'regular','name'=>'Regular'],
       [ 'id'=>'cash_advance','name'=>'Cash Advance']

    ];

    public function mount(LoanType $loanType){
// dd('here');
        $this->loanType = $loanType;

        if ($this->loanType) {
            $this->form['loan_type'] = $this->loanType->loan_type;
            $this->form['charges'] = $this->loanType->charges;
            $this->form['annual_rate'] = $this->loanType->annual_rate;
            $this->form['minimum_amount'] = $this->loanType->minimum_amount;
            $this->form['maximum_amount'] = $this->loanType->maximum_amount;
            }
        }

}; ?>

<div>
    <x-header title="{{ $loanType ?'Add ':'' }}Loan Types" separator />

    <x-form wire:submit="save">
        <x-input label="Loan Type" wire:model="name"  hint='ex: Salary loan, Calamity loan'/>

        <x-select label="Type" icon="o-user" :options="$types" wire:model.live="type" />


        @if($type=='regular')

        <x-input label="Annual Rate" wire:model="name" prefix="%" />

        @else

        @endif
        <x-input label="Charges" wire:model="form.charges" prefix="PHP" />

        <x-input label="Maximum Amount" wire:model="form.maximum_amount" prefix="PHP" />
        <x-input label="Minimum Amount" wire:model="form.minimum_amount" prefix="PHP" />



        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
