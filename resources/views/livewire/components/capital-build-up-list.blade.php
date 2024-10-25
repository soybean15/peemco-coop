<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\CapitalBuildUp;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search;
    public function with(){
        return
        [
            'cbuHeaders'=>[
                ['key' => 'id', 'label' => 'ID', 'class' => 'bg-red-500/20 w-1'],
                ['key' => 'date', 'label' => 'Date', ],
                ['key' => 'or_cdv', 'label' => 'OR CDV', ],
                ['key' => 'amount_received', 'label' => 'Amount Received', 'class' => 'hidden lg:table-cell'],
                // Alternative approach
            ],
            'capitalBuildUp'=>auth()->user()->capitalBuildUp()->search($this->search)->paginate(5)
        ];
    }

}; ?>

<div>
    <x-header title="Users" subtitle="Your home address" separator>
        <x-slot:actions>
            <x-button label="Add Capital Buildup" x-on:click="$dispatch('add-capital-build-up')"/>



    {{-- upsert-capital-build-up.blade --}}
        </x-slot:actions>



    <x-slot:middle>
        <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
    </x-slot:middle>
    </x-header>
    <x-table :headers="$cbuHeaders" :rows="$capitalBuildUp" with-pagination >
    @scope('cell_action', $capitalBuildUp)

    @endscope

    </x-table>


    <livewire:components.upsert-capital-build-up/>
</div>
