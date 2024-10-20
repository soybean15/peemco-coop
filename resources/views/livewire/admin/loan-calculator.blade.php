<?php

use Livewire\Volt\Component;

new class extends Component {
    public $result;
    public $a;
    public $b = 2;
    public $terms;

 
    public function save()
    {
        $this->result = ($this->a ?? 0) * ($this->terms[['year']] ?? 0);
    }
    
}; ?>

<div>

        <x-form wire:submit.prevent="save">
            <x-input label="Amount" wire:model.live="a" prefix="PHP" money hint="It submits an unmasked value" />

            @php
                $terms = [
                    [
                        'year' => 1,
                        'name' => '1 Year'
                    ],
                    [
                        'year' => 2,
                        'name' => '2 Years',
                    ],
                    [
                        'year' => 3,
                        'name' => '3 Years',
                    ],
                    [
                        'year' => 4,
                        'name' => '4 Years',
                    ],
                    [
                        'year' => 5,
                        'name' => '5 Years'
                    ]
                ];
            @endphp
 
            <x-select label="Terms " :options="$terms" wire:model="selectedTerms" />
        
            <x-slot:actions>
                <x-button label="Cancel" />
                <x-button label="Click me!" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
        <!-- Sonuç : {{ $result }} -->
</div>
