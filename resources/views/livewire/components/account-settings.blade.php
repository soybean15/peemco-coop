<?php

use Livewire\Volt\Component;
use App\Models\User;

use Illuminate\Validation\Rules;

new class extends Component {
    public $user;
    public $name;


    public function mount($user_id)
    {
        $this->user = User::find($user_id);
        $this->name = $this->user->name;
    }

    public function updateAccount()
    {
        $validated = $this->validate([
            'name'=>'required|max:255'
        ]);
        $this->user->update($validated);
    }
}; ?>

<div>
    {{$user->id}}
    <form wire:submit="updateAccount">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

       

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                    {{ __('Update') }}
            </x-primary-button>
        </div>
        
    </form>

</div>

