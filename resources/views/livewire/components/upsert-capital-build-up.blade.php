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
    <x-modal wire:model="modal" title="Hello" subtitle="Livewire example" separator>
        <x-form wire:submit="save">
            <x-input label="Name" wire:model="name" />
            <x-input label="Amount" wire:model="amount" prefix="USD" money hint="It submits an unmasked value" />

            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>

        <x-slot:actions>
            <x-button label="Cancel" @click="$wire.modal = false" />
            <x-button label="Confirm" class="btn-primary" />
        </x-slot:actions>
    </x-modal>

</div>
