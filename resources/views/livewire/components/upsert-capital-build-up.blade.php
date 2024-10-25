<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
use  App\Models\CapitalBuildUp;
use  App\Models\User;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    public $modal =false;

    public $amount;
    public $or_cdv;

    public $date;

    public $user;

    public $capitalBuildUp;

    #[On('add-capital-build-up')]
    public function onAdd($user_id){

        $this->user = User::find($user_id);
        $this->modal = true;
        $this->capitalBuildUp=null;
        $this->on_edit =false;
        $this->amount = null;
        $this->or_cdv = null;
        $this->date =null;
    }
    #[On('edit-capital-build-up')]
    public function onEdit($user_id,$id){
        $this->modal = true;
        $this->capitalBuildUp = CapitalBuildUp::find($id);
        $this->amount = $this->capitalBuildUp->amount_received;
        $this->or_cdv = $this->capitalBuildUp->or_cdv;
        $this->date = $this->capitalBuildUp->date;
    }

   #[Computed]



    public function submit(){

        $this->validate([
                'or_cdv'=>'required',
                'amount'=>'required',
                'date'=>'required|date',
        ]);
        if($this->capitalBuildUp){
            $this->capitalBuildUp->update(
                [
                'or_cdv'=>$this->or_cdv,
                'amount_received'=>$this->amount,
                'date'=>$this->date,

        ]
        );

        $this->success('Data has been Updated');


        }else{



            $this->user->capitalBuildUp()->create([
                'or_cdv'=>$this->or_cdv,
                'amount_received'=>$this->amount,
                'date'=>$this->date,
                'added_by'=>auth()->user()->id
        ]);
        $this->success('New data created');

        }


        $this->modal=false;

        $this->dispatch('refresh-table');

    }

    public function edit(){

    }

    public function create(){

    }

}; ?>

<div>
    <x-modal wire:model="modal" title="Capital Build Up" subtitle="Add/Update" separator>

        <x-stat title="Total Capital Build up" description="This month" value="22.124" icon="o-square-3-stack-3d"
            tooltip-bottom="There" />
        <x-form>

            <x-datetime label="Date" wire:model="date" icon="o-calendar" />
            <x-input label="OR CDV" wire:model="or_cdv" />
            <x-input label="Amount" wire:model="amount" prefix="PHP" hint="It submits an unmasked value"
                type='number' />

        </x-form>

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.modal = false" />
            <x-button wire:click='submit' label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

</div>
