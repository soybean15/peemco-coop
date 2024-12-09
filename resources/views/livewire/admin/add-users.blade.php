<?php

use App\Helpers\IdGenerator;
use Livewire\Volt\Component;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Mary\Traits\Toast;
use App\Helpers\PasswordGenerator;
new class extends Component {

    use Toast;

    public string $name = '';
    public string $middlename = '';
    public string $lastname = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {


        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'lowercase', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            ]
        );

        //dd($validated);
        $password = PasswordGenerator::generate(5);
        $validated['password'] = Hash::make($password);
        $validated['mid'] = IdGenerator::generateId('MID',10);
        $user = User::create($validated);
        UserProfile::firstOrCreate(['user_id' => $user->id]);
        $this->success('New Member Successfully added');
        // session()->flash('success','Member Created Successfully');
        // $this->redirect(route('add-users', absolute: false), navigate: true);


            UserProfile::firstOrCreate(['user_id' => $user->id]);
            $user->assignRole('Member');

        $this->dispatch('user-added',password:$password );

    }

}; ?>

<div>
    <x-header title="Add User"  separator />

    <form wire:confirm='Continue adding user?' wire:submit="register" class="flex flex-col space-y-4">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Firstname')" />
            <x-text-input wire:model="name" id="name" class="block w-full mt-1" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Middlename -->
        <div>
            <x-input-label for="middlename" :value="__('Middlename')" />
            <x-text-input wire:model="middlename" id="middlename" class="block w-full mt-1" type="text" name="middlename" required autofocus autocomplete="middlename" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>


        <!-- Lastname -->
        <div>
            <x-input-label for="lastname" :value="__('Lastname')" />
            <x-text-input wire:model="lastname" id="lastname" class="block w-full mt-1" type="text" name="lastname" required autofocus autocomplete="lastname" />
            <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
        </div>

        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input wire:model="username" id="username" class="block w-full mt-1" type="text" name="username" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>


        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block w-full mt-1" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input wire:model="password" id="password" class="block w-full mt-1"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div> --}}

        <!-- Confirm Password -->
        {{-- <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block w-full mt-1"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div> --}}

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-4">
                {{ __('Create User') }}
            </x-primary-button>
        </div>
    </form>



    <script>
         window.addEventListener('user-added', (event) => {
            Swal.fire({
                title: 'User Created!',
                text: 'Do you want to continue',
                html: `
                    <p>The generated password is:</p>
                    <p><b>${event.detail.password}</b></p>
                    <p>Please save this password before closing the dialog.</p>
                `,
                icon: 'success',
                confirmButtonText: 'Cool'
            })
        // alert(event.detail.message);
            });
    </script>
</div>
