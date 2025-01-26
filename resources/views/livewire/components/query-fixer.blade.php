<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {



    public function handle(){

        User::all()->each(function($user){
            $user->assignRole('Member');

        });
    }
}; ?>

<div>

    <button  class="text-white border border-none rounded-sm bg-primary " wire:click='handle'>

        Fix query
    </button>
</div>
