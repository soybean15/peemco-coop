<?php

use Livewire\Volt\Component;

new class extends Component {
    public $result;
    public $a;
    public $b;
    
    public function updated()
    {
        $this->result = ($this->a ?? 0) + ($this->b ?? 0);
    }
    
}; ?>

<div>
    <label>Sayı 1:</label>
        <input type="text" id="a" name="a" wire:model.lazy="a">

        <br>
        <label>Sayı 2:</label>
        <input type="text" id="b" name="b" wire:model.lazy="b">
        
        <br>
        Sonuç : {{ $result }}
</div>
