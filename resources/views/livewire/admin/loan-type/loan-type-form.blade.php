<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
use Mary\Traits\Toast;
use App\Models\LoanReleaseDate;
use  App\Services\LoanType\LoanTypeService;
new class extends Component {

    use Toast;
    public $loanType;
    public $type='regular';

    public $releaseDates=[];

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
            // $this->form['loan_type'] = $this->loanType->loan_type;
            // $this->form['charges'] = $this->loanType->charges;
            // $this->form['annual_rate'] = $this->loanType->annual_rate;
            // $this->form['minimum_amount'] = $this->loanType->minimum_amount;
            // $this->form['maximum_amount'] = $this->loanType->maximum_amount;

            $this->form = $this->loanType->toArray();
            $this->type = $this->loanType->type;


            $this->releaseDates = $this->loanType->getReleaseDates();
        }
        }

    public function save(){


        $this->form['type']=$this->type;


        if($this->type =='regular'){
            $this->validate([
                'form.loan_type'=>'required|max:50',
                'form.maximum_amount'=>'required|numeric|gte:form.minimum_amount',
                'form.minimum_amount'=>'required|numeric',
                'form.annual_rate'=>'required|numeric',
                'form.charges'=>'required|numeric',


            ]);

        }else{

            $this->validate([
                'form.loan_type'=>'required|max:50',
                'form.maximum_amount'=>'required|numeric|gte:form.minimum_amount',
                'form.minimum_amount'=>'required|numeric',
                'form.charges'=>'required|numeric',
                'releaseDates.*.start'=>'required',
                'releaseDates.*.end'=>'required',
            ]);

        }

        // dd($this->form);
        if($this->loanType){


            $this->update();
        }else{
            $this->store();

        }
    }

    public function store(){



        LoanTypeService::store(
            [
                'form'=>$this->form,
                'releaseDates'=>$this->releaseDates,
                'type'=>$this->type
            ]
            );
            return redirect()->to(route('admin.loan-type'));
            $this->success('Added new Loan Type');
    }
    public function update(){

        $this->loanType->update($this->form);
    }

    public function addReleases(){


        $this->releaseDates[] =[ 'start'=>null, 'end'=>null];

    }

    public function reduceReleases(){
        array_pop($this->releaseDates);
    }
}; ?>

<div>
    <x-header title="{{ !$loanType ?'Add ':'' }}Loan Type" separator />

    <x-form wire:submit="save">
        <x-input label="Loan Type" wire:model="form.loan_type" hint='ex: Salary loan, Calamity loan' />

        <x-select label="Type" icon="o-user" :options="$types" wire:model.live="type" />

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            @if($type=='regular')
            <x-input label="Annual Rate" type='number' wire:model="form.annual_rate" prefix="%" step="0.01" />

            @endif
            <x-input label="Charges" type='number' wire:model="form.charges" prefix="%" step="0.01" />


        </div>

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <x-input label="Minimum Amount" wire:model="form.minimum_amount" prefix="PHP" step="0.01" />
            <x-input label="Maximum Amount" wire:model="form.maximum_amount" prefix="PHP" step="0.01" />
            <x-input label="Penalty" wire:model="form.penalty" prefix="%" step="0.01" />
            <x-input label="Grace period" wire:model="form.grace_period" prefix="%" step="0.01" />
        </div>

        @if($type=='cash_advance')
        <div class="flex items-center">
            <span>Date Releases</span>
            <x-button icon="o-minus" class="mx-3 btn-circle btn-sm btn-success" wire:click='reduceReleases' />
            <span>{{ count($releaseDates) }}</span>
            <x-button icon="o-plus" class="mx-3 btn-circle btn-sm btn-success" wire:click='addReleases' />
        </div>
        <div class="grid grid-cols-1">
            @php
                $config = [
                    'dateFormat'=> "m-d",
                    'altFormat' => 'F J',

            ];
            @endphp

            @foreach ( $releaseDates as $dates )

            <div class="grid grid-cols-1 gap-4 my-2 md:grid-cols-2">
                <x-datepicker label="Start" wire:model="releaseDates.{{ $loop->index }}.start" icon="o-calendar" :config="$config" />
                <x-datepicker label="End" wire:model="releaseDates.{{ $loop->index }}.end" icon="o-calendar" :config="$config" />

                {{-- <x-datetime label="Start" wire:model="releaseDates.{{ $loop->index }}.start" icon="o-calendar" />
                <x-datetime label="End" wire:model="releaseDates.{{ $loop->index }}.end" icon="o-calendar" /> --}}


            </div>





            @endforeach


        </div>


        @endif

        <x-slot:actions>

            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
</div>
