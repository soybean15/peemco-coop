<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\CapitalBuildUp;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search;
    public $users;

   

    public function mount()
    {
       $this->users = auth()->user()->id;
       $this->sample =1;
    }

    public function with(): array
    {
        return
        [
            'cbuHeaders'=>[
                ['key' => 'or_cdv', 'label' => 'OR CDV', ],
                ['key' => 'date', 'label' => 'Date', ],
                ['key' => 'amount_received', 'label' => 'Amount Received', 'class' => 'hidden lg:table-cell'],
                ['key' => 'added_by', 'label' => 'Added By', ],
                ['key' => 'action', 'label' => 'Action', ],
                // Alternative approach
            ],
            'capitalBuildUp'=> CapitalBuildUp::where('user_id',$this->users)
                ->where('or_cdv', 'LIKE', "%$this->search%")
                ->paginate(10)
        ];
    }

 

}; ?>

<div>
    <x-header title="Capital Build up" subtitle="Total Shares" separator>
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
        </x-slot:actions>
    </x-header>
    <x-table :headers="$cbuHeaders" :rows="$capitalBuildUp" striped with-pagination x-on:refresh-table.window='$wire.$refresh()' />   
   
</div>
