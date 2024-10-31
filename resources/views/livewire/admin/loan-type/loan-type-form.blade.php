<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
use Mary\Traits\Toast;
new class extends Component {

    use Toast;
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

    public function mount( $loanTypeId=null){
// dd('here');
        $this->loanType = LoanType::find($loanTypeId);

        if ($this->loanType) {
            $this->form['loan_type'] = $this->loanType->loan_type;
            $this->form['charges'] = $this->loanType->charges;
            $this->form['annual_rate'] = $this->loanType->annual_rate;
            $this->form['minimum_amount'] = $this->loanType->minimum_amount;
            $this->form['maximum_amount'] = $this->loanType->maximum_amount;
            }
        }

    public function save(){


        $this->form['type']=$this->type;

        // dd($this->form);
        if($this->loanType){


            $this->update();
        }else{
            $this->store();

        }
    }

    public function store(){
        $this->validate([
                'form.loan_type'=>'required|max:50',
                'form.maximum_amount'=>'required|numeric',
                'form.minimum_amount'=>'required|numeric',
                'form.annual_rate'=>'required|numeric',
                'form.charges'=>'required|numeric',

            ]);


            LoanType::create($this->form);

            return redirect()->to(route('admin.loan-type'));
            $this->success('Added new Loan Type');
    }
    public function update(){
        $this->validate([
                'form.loan_type'=>'required|max:50',
                'form.maximum_amount'=>'required|numeric',
                'form.minimum_amount'=>'required|numeric',
                'form.charges'=>'required|numeric',

            ]);
        $this->loanType->update($this->form);
    }

}; ?>

<div>
    <x-header title="{{ !$loanType ?'Add ':'' }}Loan Type" separator />

    <x-form wire:submit="save">
        <x-input label="Loan Type" wire:model="form.loan_type"  hint='ex: Salary loan, Calamity loan'/>

        <x-select label="Type" icon="o-user" :options="$types" wire:model.live="type" />

        @if($type=='regular')
        <x-input label="Annual Rate" wire:model="form.annual_rate" prefix="%" />

        @endif
        <x-input  label="Charges" wire:model="form.charges" prefix="%" />

        <x-input label="Maximum Amount" wire:model="form.maximum_amount" prefix="PHP" />
        <x-input label="Minimum Amount" wire:model="form.minimum_amount" prefix="PHP" />



        <x-slot:actions>

            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
