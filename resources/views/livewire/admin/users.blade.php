<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\WithPagination;
use Livewire\Attributes\{Layout, Title};
use Illuminate\View\View;

new class extends Component {
    use WithPagination;
    public $search;

    public function rendering(View $view): void
    {
        $view->title('Admin - Users');


    }

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
            'users'=>User::search($this->search)->paginate(10)
        ];
    }

    public function deleteUser(User $user){

        $user->delete();

    }


}; ?>

<div>
    @if(session()->has('success'))
        <x-icon name="o-check" class="text-2xl text-green-500 w-9 h-9" label=" {{session('success')}}"/>
    @endif

    <x-header title="Users" subtitle="Your home address" separator>
        {{-- <x-slot:actions>
            <x-input icon="o-magnifying-glass" wire:model.live='search' placeholder="Search Members" />
            @can('add user')
            <x-button icon="o-user-plus" label="Add Member" link="{{route('admin.add-users')}}" class="btn-primary" />
            @endcan
        </x-slot:actions> --}}
        <x-slot:actions>
            @can('add user')
            <x-button icon="o-user-plus" label="Add Member" link="{{route('admin.add-users')}}" class="btn-primary btn-sm" />
            @endcan
        </x-slot:actions>
    </x-header>
    <x-table :headers="$userHeaders" :rows="$users" with-pagination >

        @scope('cell_action', $user)
        <x-button icon='o-eye' class="btn-ghost btn-sm" link="{{route('admin.user',['user'=>$user->id])}}"/>
        <x-button icon='o-archive-box' class="btn-error btn-sm" wire:confirm='Are you sure you want archive this Employee?' wire:click='deleteUser({{ $user }})'/>
        @endscope
    </x-table>
</div>
