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
                ['key' => 'date', 'label' => 'Date', 'class' => 'bg-red-500/20 w-1'],
                ['key' => 'or_cdv', 'label' => 'OR CDV', 'class' => 'bg-red-500/20 w-1'],
                ['key' => 'amount_received', 'label' => 'Amount Received', 'class' => 'hidden lg:table-cell'], 
                // Alternative approach
            ],
            'capitalBuildUp'=>CapitalBuildUp::paginate()
        ];
    }

}; ?>

<div>
    <x-header title="Users" subtitle="Your home address" separator>

    <x-slot:actions>
        <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
    </x-slot:actions>
    </x-header>
    <x-table :headers="$cbuHeaders" :rows="$capitalBuildUp" with-pagination >
    @scope('cell_action', $capitalBuildUp)

    @endscope
  
    </x-table>

 

</div>
