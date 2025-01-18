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
    <x-stat
        title="Capital Buildup"
        {{-- description="This month" --}}
        value="₱{{ number_format(CapitalBuildUp::where('user_id',$this->users)->sum('amount_received'),2) }}"
        icon="o-arrow-trending-up"
    />
    <x-table :headers="$cbuHeaders" :rows="$capitalBuildUp" striped with-pagination x-on:refresh-table.window='$wire.$refresh()'>   
        @scope('cell_or_cdv', $capitalBuildUp)
            {{ $capitalBuildUp->or_cdv}}
        @endscope
        @scope('cell_date', $capitalBuildUp)
            {{ \Carbon\Carbon::parse($capitalBuildUp->date)->toFormattedDateString() }}
        @endscope
        @scope('cell_amount_received', $capitalBuildUp)
            ₱ {{ number_format(($capitalBuildUp->amount_received),2) }}
        @endscope
        @scope('cell_added_by', $capitalBuildUp)
            {{ $capitalBuildUp->addedBy->name}}
        @endscope
    </x-table>
</div>
