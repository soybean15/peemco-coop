<?php

use Livewire\Volt\Component;



new class extends Component {


    public function with(){
       return [
        'user'=>auth()->user()
    ];
    }

}; ?>

<div>

    <div class="flex p-5 space-x-5">

        <x-file wire:model="photo" accept="image/png, image/jpeg">
            <img src="{{ $user->avatar ?? '/default/default-user.png' }}" class="!w-28" />
        </x-file>
        <div class="w-full pt-3">
            <x-header
            class="w-full "
            title="{{html_entity_decode($user->name)}} {{html_entity_decode($user->middlename)}} {{html_entity_decode($user->lastname)}}"
            subtitle="{{$user->email}}" separator >
            <x-slot:middle class="!justify-end ">
                <span class="text-base label-text">Member ID: <b>{{html_entity_decode($user->mid)}}</b></span>
            </x-slot:middle></x-header>

        </div>
    </div>
    <livewire:components.user-profile :user="auth()->user()"/>


</div>
