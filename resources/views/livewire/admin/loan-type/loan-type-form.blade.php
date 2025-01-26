<?php

use Livewire\Volt\Component;
use App\Models\LoanType;
use Mary\Traits\Toast;
use App\Models\LoanReleaseDate;
use  App\Services\LoanType\LoanTypeService;
use Livewire\Attributes\On;
new class extends Component {

    use Toast;
    public $loanType;
    public $type;

    public $chargeAmount;
    public $releaseDates=[];

    public $form=[
        'loan_type'=>null,
        'charges'=>null,
        'annual_rate'=>null,
        'minimum_amount'=>null,
        'maximum_amount'=>null,
        'maximum_period'=>0,
        'is_compound_penalty'=>false


        ];
    public $types = [

       [ 'id'=>'regular','name'=>'Regular'],
       [ 'id'=>'flexible','name'=>'Flexible'],
       [ 'id'=>'cash_advance','name'=>'Cash Advance']

    ];

    public function mount($loanTypeId = null)
    {
    $loanTypeId = $loanTypeId ?? session('loan_type_id');

        if ($loanTypeId) {
            $this->setLoanTypeData($loanTypeId);
        }
        // dd($this->releaseDates);
    }


        public function updatedFormCharges($value)
    {

        if($value && $value>0){
            $this->computeChargeAmount($value);
        }
    }

    public function updatedFormMinimumAmount(){

        // dd('jer');
        if($this->form['charges'] && $this->form['charges']>0){
            $this->computeChargeAmount($this->form['charges']);
        }
    }

    public function computeChargeAmount($value){
         // Assuming $this->charges is the percentage (e.g., 3 for 3%)
         $chargesPercentage = $value; // 3
        $minimumAmount = $this->form['minimum_amount']; // 1000

        // Calculate the charge amount based on the percentage
        $chargeAmount = ($chargesPercentage / 100) * $minimumAmount;

        // Update the charge_amount field
        $this->chargeAmount = $chargeAmount; // This will be 30
    }
    private function setLoanTypeData($loanTypeId)
    {
        $this->loanType = LoanType::find($loanTypeId);

        if ($this->loanType) {
            $this->form = $this->loanType->toArray();
            $this->type = $this->loanType->type??'regular';

            $this->releaseDates = $this->loanType->getReleaseDates()->toArray();
            $this->computeChargeAmount($this->form['charges']);

        }
    }


    #[On('submit-loan-type')]
    public function save(){

        // $loanTypeId = $loanTypeId ?? session('loan_type_id');

        // $this->setLoanTypeData($loanTypeId);

        $service = new LoanTypeService($this->loanType);

        // dd($this->form);
        if($this->loanType){


            $this->update($service);
        }else{
            $this->store($service);

        }
        $this->dispatch('move-next-step');
    }



    public function store(  $service){


        $this->form['type']=$this->type;
        $this->validate(
            ['type'=>'required']
    );

        $service->store(
            [
                'form'=>$this->form,
                'releaseDates'=>$this->releaseDates,
                'type'=>$this->type
            ]
        );


        // $this->success('Added new Loan Type');

        // return redirect()->to(route('admin.loan-type'));
    }
    public function update( $service){


        $this->form['type']=$this->type;
        // dd($this->form);
        $service->update([
            'form'=>$this->form,
            'type'=>$this->type,
            'releaseDates'=>$this->releaseDates
        ]);

    }

    public function addReleases(){

        // dd('here');



        $this->releaseDates[] =[ 'start'=>null, 'end'=>null];
        // dd($this->releaseDates);

    }

    public function reduceReleases(){

        array_pop($this->releaseDates);
    }
}; ?>

<div>


    @php

    $disabled = request()->route()->getName()=='admin.loan-type-profile';
    @endphp

    <x-header title="{{ !$loanType ?'Add ':'' }}Loan Type" separator />

    <x-form wire:submit="save" >


            <x-select label="Type" icon="o-user" :options="$types" wire:model.live="type" placeholder="Select loan type" :disabled="$disabled"/>

            <x-input label="Loan Type" wire:model.live="form.loan_type" hint='ex: Salary loan, Calamity loan' :disabled="$disabled" />

            @if($type=='regular' || $type=='flexible')


            <x-input label="Annual Rate" type='number' wire:model="form.annual_rate" prefix="%" step="0.01" :disabled="$disabled"/>
            <x-input label="Charges" type='number' wire:model="form.charges" prefix="%" step="0.01" :disabled="$disabled"/>
            <x-input label="Minimum Amount" wire:model.live="form.minimum_amount" prefix="PHP" step="0.01" :disabled="$disabled"/>
            <x-input label="Maximum Amount" wire:model="form.maximum_amount" prefix="PHP" step="0.01" :disabled="$disabled"/>

            <x-input label="Maximum Period" wire:model="form.maximum_period" hint="Maximum period in months" type="number" :disabled="$disabled"/>
            @endif
            <x-input label="Penalty" wire:model="form.penalty" prefix="%" step="0.01" :disabled="$disabled"/>
            <x-input label="Grace period" wire:model="form.grace_period" prefix="Days" step="0.01" />
            <x-checkbox label="Compound penalty" wire:model="is_compound_penalty" hint="When enabled, penalties from the previous term will be added to the next penalty calculation." />

            @if($type=='cash_advance')

                <x-input label="Amount" wire:model.live="form.minimum_amount" prefix="PHP" step="0.01" />
                <x-input label="Charges" type='number' wire:model.live="form.charges" prefix="%" step="0.01" />
                <x-input label="Charge Amount" value="{{ $this->chargeAmount ??0}}" readonly />

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
                    <x-datepicker label="Start" wire:model="releaseDates.{{ $loop->index }}.start" icon="o-calendar"
                        :config="$config" />
                    <x-datepicker label="End" wire:model="releaseDates.{{ $loop->index }}.end" icon="o-calendar"
                        :config="$config" />
                </div>

            @endforeach


        </div>


        @endif


        <x-slot:actions>

            {{--
            <x-button label="Save" class="btn-primary" type="submit" spinner="save" /> --}}
        </x-slot:actions>
    </x-form>
</div>
