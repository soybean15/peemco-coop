<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;

new class extends Component {

    use WithPagination;
    public $search;

    public function with(){


        return [

        'loans'=>auth()->user()->loans()
        ->search($this->search)
        ->paginate(5),
        'renderFrom'=> null

    ];
    }
}; ?>

<div>
    <x-header title="Loans" separator >
        <x-slot:actions>
        <x-button class="btn-success" label='Add Loan' link="{{ route('user.loan-calculator') }}" />
    </x-slot:actions>
    </x-header>
    <livewire:components.loan-list :renderFrom='$renderFrom'/>
</div>
