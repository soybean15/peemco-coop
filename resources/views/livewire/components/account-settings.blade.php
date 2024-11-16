<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Mary\Traits\Toast;


new class extends Component {
    
    use Toast;
    
    public $user;
    public string $name;
    public string $middlename;
    public string $lastname;
    public string $username;
    public string $email;
    public string $password;
    public string $password_confirmation = '';




    public function mount($user_id)
    {
        $this->user = User::find($user_id);
        $this->name = $this->user->name;
        $this->middlename = $this->user->middlename;
        $this->lastname = $this->user->lastname;

        $this->password = $this->user->password;
    }

    public function updateBasicInfo()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'middlename' => [''],
            'lastname' => ['required', 'string', 'max:255'],
            ]
        );
       
        $this->user->update($validated);
        $this->success('Basic Information Updated Successfully');
    }


    public function resetPassword()
    {
        $validated = $this->validate([
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]
        );
        $validated['password'] = Hash::make($validated['password']);
        $this->user->update($validated);
        $this->success('Password Has been reset Successfully');
    }


   
}; ?>

<div>
    <form wire:submit="updateBasicInfo">
        <h6><b>Basic Information</b></h6>
        <br>
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="middlename" :value="__('Middlename')" />
            <x-text-input wire:model="middlename" id="middlename" class="block mt-1 w-full" type="text" name="middlename" required autofocus autocomplete="middlename" />
            <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="lastname" :value="__('Lastname')" />
            <x-text-input wire:model="lastname" id="lastname" class="block mt-1 w-full" type="text" name="lastname" required autofocus autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <hr>

    
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Update') }}
            </x-primary-button>
        </div>
           
    </form>
    <br>

    <h6><b>Reset Password</b></h6>
    <form wire:submit="resetPassword">
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation"  autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>

</div>

