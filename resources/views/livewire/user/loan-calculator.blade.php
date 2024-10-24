<?php

use Livewire\Volt\Component;

new class extends Component {


    public function applyLoan(){




    }
}; ?>

<div>
    <x-header title="Loan Calculator" separator >
        <x-slot:actions>

        <x-button class="btn-success" label='Apply Loan' wire:confirm='Are you sure you want to apply this loan?' wire:click='applyLoan'/>
    </x-slot:actions>

    </x-header>
    <livewire:components.loan-calculator-component />

</div>
