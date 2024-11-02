<?php

use Livewire\Volt\Component;

new class extends Component {
    //
    // public function mount(){
    //     dd('here');
    // }
}; ?>

<div>
  <div>

    <x-header title="Dashboard" subtitle="Welcome Adnub" separator />


    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <x-bar-chart/>
        <x-area-chart/>
        <x-pie-chart/>
        <x-column-chart/>

    </div>
  </div>
</div>
