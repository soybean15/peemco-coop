<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\CapitalBuildUp;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;
    public $search;
    public $user;

    public function mount($user_id){

        $this->user = User::find($user_id);

    }
    public function with(){
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
            'capitalBuildUp'=>$this->user->capitalBuildUp()->search($this->search)->paginate(5)
        ];
    }

    public function delete(CapitalBuildUp $capitalBuildUp){
        $capitalBuildUp->delete();
    }

}; ?>

<div>
    <x-header title="Capital Build up" subtitle="Your home address" separator>
        <x-slot:actions>
            <x-button label="Add Capital Buildup" x-on:click="$dispatch('add-capital-build-up',{user_id:{{ $this->user->id }}})"/>
            {{-- upsert-capital-build-up.blade --}}
        </x-slot:actions>



        <x-slot:middle>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search..." />
        </x-slot:middle>
    </x-header>


    <x-stat
    title="Capital Buildup"
    {{-- description="This month" --}}
    value="₱{{ number_format($this->user->capitalBuildUp()->sum('amount_received'),2) }}"
    icon="o-arrow-trending-up"
    />


    <x-table :headers="$cbuHeaders" :rows="$capitalBuildUp" with-pagination x-on:refresh-table.window='$wire.$refresh()'>
    @scope('cell_or_cdv', $capitalBuildUp)
    {{ $capitalBuildUp->or_cdv}}
    @endscope
    @scope('cell_date', $capitalBuildUp)
    {{ $capitalBuildUp->date}}

    @endscope
    @scope('cell_amount_received', $capitalBuildUp)

    {{ $capitalBuildUp->amount_received}}
    @endscope
    @scope('cell_added_by', $capitalBuildUp)
    {{ $capitalBuildUp->addedBy->name}}

    @endscope
    @scope('cell_action', $capitalBuildUp)


    <x-button icon="o-pencil-square" class="btn-ghost" x-on:click="$dispatch('edit-capital-build-up',{user_id:{{ $this->user->id }},id:{{ $capitalBuildUp->id }}})"/>
    <x-button icon="o-trash" class="btn-error" wire:confirm='Are you sure you want to delete this item?' wire:click='delete({{ $capitalBuildUp->id }})'/>

    @endscope


    </x-table>


    <livewire:components.upsert-capital-build-up/>
</div>
