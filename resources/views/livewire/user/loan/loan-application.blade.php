<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<div>
    <x-bread-crumbs :routes="[
        ['label'=>'Select Loan','name'=>'user.loan-application'],
        ['label'=>'Regular Loan']

    ]"/>

    <livewire:components.apply-loan renderFrom="user"/>
</div>
