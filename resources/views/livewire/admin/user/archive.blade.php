<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\WithPagination;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    use WithPagination;
    public $search;
    public function with(){
        return
        [
            'userHeaders'=>[
                ['key' => 'mid', 'label' => 'MID', 'class' => 'bg-red-500/20 w-1'],
                ['key' => 'name', 'label' => 'First Name'],
                ['key' => 'middlename', 'label' => 'Middle Name'],
                ['key' => 'lastname', 'label' => 'Last Name'],
                ['key' => 'username', 'label' => 'Username'],
                ['key' => 'email', 'label' => 'E-mail', 'class' => 'hidden lg:table-cell'],
                ['key' => 'action', 'label' => 'Action', 'class' => 'hidden lg:table-cell'],
                // Alternative approach
            ],
            'users'=>User::onlyTrashed()->search($this->search)->paginate(10)
        ];
    }


    public function restoreUser(User $user){

        $user->restore();
    }
    public function deleteUser(User $user){
        $user->forceDelete();
    }

}; ?>

<div>
    {{-- @if(session()->has('success'))
        <x-icon name="o-check" class="text-2xl text-green-500 w-9 h-9" label=" {{session('success')}}"/>
    @endif --}}

    <x-header title="Users" subtitle="Your home address" separator>
        <x-slot:actions>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search Members" />
            @can('add user')
            <x-button icon="o-user-plus" label="Add Member" link="{{route('admin.add-users')}}" class="btn-primary"  />
            @endcan
        </x-slot:actions>
    </x-header>
    <x-table :headers="$userHeaders" :rows="$users" with-pagination >

        @scope('cell_action', $user)
            <x-button wire:click='restoreUser({{ $user }})' icon='o-arrow-path' class="btn-info btn-sm"/>
            <x-button  wire:click='deleteUser({{ $user }})' icon='o-trash'  class="btn-error btn-sm"/>

        @endscope
    </x-table>
</div>
