<?php

use Livewire\Volt\Component;
use Livewire\Attributes\On;
new class extends Component {

    public $modal =false;

    #[On('add-capital-build-up')]
    public function onAdd(){
      $this->modal = true;
    }




}; ?>

<div>
    <x-modal wire:model="modal" title="Capital Build Up" subtitle="Add/Update" separator>
        <x-form wire:submit="save">

            <x-datetime label="Date" wire:model="myDate" icon="o-calendar" />

            <x-input label="OR CDV" wire:model="name" />
            <x-input label="Amount" wire:model="amount" prefix="PHP" money hint="It submits an unmasked value" />

        </x-form>

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.modal = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

</div>
