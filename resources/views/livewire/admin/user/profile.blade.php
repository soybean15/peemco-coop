<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    use WithFileUploads;
    public User $user;

    public $photo;
    public $selectedTab='profile';

    public $form=[
        'name'=>null
    ];




    public function save(){
        $this->validate([
            'form.name'=>'required|max:50',
            'photo'=>'image|max:5120',
    ]);


        $this->user->addMedia($this->photo)->toMediaCollection('profile');

        $this->user->update($this->form);

        $this->success('Profile Updated');
    }

    // public function mount(User $user){
    //     $thi
    //     // dd($user);
    // }
}; ?>
<div>
    <div class="p-3 m-1 border-2 border-gray-600 rounded shadow-md ">
        <div class="flex flex-col justify-start md:flex-row">



            <div class="flex justify-center my-5 md:p-20">

                <x-file wire:model="photo" accept="image/png, image/jpeg">
                    <img src="{{ $user->avatar ?? '/default/default-user.png' }}" class="!w-52" />
                </x-file>
                {{-- <x-mary-file wire:model="photo" accept="image/png" crop-after-change>
                    <img src="{{ $user->avatar ?? '/storage/defaults/user-default.png' }}" class="h-40 rounded-lg" />
                </x-mary-file> --}}
            </div>


            <div class="flex flex-col w-full px-5 md:p-5">
                <x-tabs wire:model="selectedTab">
                <x-tab name="profile" label="Profile" icon="o-users">
                    <x-header title="{{html_entity_decode($user->name)}}" subtitle="{{$user->email}}" separator />
                        <div class="grid grid-cols-1 gap-2 md:grid-cols-2 ">

                            <x-input label="Name" wire:model="form.name" />
                            <x-input label="Contact Number" wire:model="form.contact_number" />
                            <x-input label="Address" wire:model="form.address" />
                            {{-- <x-input label="Prefix & Suffix" wire:model="name" />
                            <x-input label="Prefix & Suffix" wire:model="name"/> --}}
                        </div>
                        <div class="flex justify-end px-5">
                            <x-button label='Save' class="btn-primary btn-sm" wire:click='save'/>
                        </div>
                </x-tab>

                <x-tab name="capital_build_up" label="Capital Build up" icon="o-credit-card">
                   <livewire:components.capital-build-up-list :user_id='$user->id'/>
                </x-tab>    
        

            </x-tabs>
                {{-- {{html_entity_decode($user->)}} --}}
            </div>


        </div>


   

    </div>
</div>
