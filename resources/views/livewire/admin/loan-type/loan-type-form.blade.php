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

    public function mount($loanTypeId = null)
    {
    $loanTypeId = $loanTypeId ?? session('loan_type_id');

        if ($loanTypeId) {
            $this->setLoanTypeData($loanTypeId);
        }
    }

    private function setLoanTypeData($loanTypeId)
    {
        $this->loanType = LoanType::find($loanTypeId);

        if ($this->loanType) {
            $this->form = $this->loanType->toArray();
            $this->type = $this->loanType->type??'regular';
            $this->releaseDates = $this->loanType->getReleaseDates();
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
        $service->update($this->form);

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
        <x-input label="Loan Type" wire:model.live="form.loan_type" hint='ex: Salary loan, Calamity loan' />

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
            <x-input label="Grace period" wire:model="form.grace_period" prefix="Days" step="0.01" />
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
                <x-datepicker label="Start" wire:model="releaseDates.{{ $loop->index }}.start" icon="o-calendar"
                    :config="$config" />
                <x-datepicker label="End" wire:model="releaseDates.{{ $loop->index }}.end" icon="o-calendar"
                    :config="$config" />

                {{--
                <x-datetime label="Start" wire:model="releaseDates.{{ $loop->index }}.start" icon="o-calendar" />
                <x-datetime label="End" wire:model="releaseDates.{{ $loop->index }}.end" icon="o-calendar" /> --}}


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
