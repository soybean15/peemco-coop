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
    <div class=" shadow-md border-2 border-gray-600 rounded m-1 p-3 ">
        <div class="flex flex-col md:flex-row justify-start">
    
    
            
            <div class="flex justify-center my-5 md:p-20">
    
            
                <x-file wire:model="photo" accept="image/png, image/jpeg">
                    <img src="{{ $user->avatar ?? '/default/default-user.png' }}" class="!w-52" />
                </x-file>
                {{-- <x-mary-file wire:model="photo" accept="image/png" crop-after-change>
                    <img src="{{ $user->avatar ?? '/storage/defaults/user-default.png' }}" class="h-40 rounded-lg" />
                </x-mary-file> --}}
            </div>
    
    
            <div class="flex flex-col w-full px-5 md:p-5">
    
                {{-- {{html_entity_decode($user->name)}} --}}
                <x-header title="{{html_entity_decode($user->name)}}" subtitle="{{$user->email}}" separator />
    
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-2 ">
                 
                    <x-input label="Name" wire:model="form.name" />
                    <x-input label="Contact Number" wire:model="form.contact_number" />
                    <x-input label="Address" wire:model="form.address" />
                    {{-- <x-input label="Prefix & Suffix" wire:model="name" />
                    <x-input label="Prefix & Suffix" wire:model="name"/> --}}
                </div>
    
            </div>

           
        </div>
    
     
        <div class="flex justify-end px-5">
            <x-button label='Save' class="btn-primary btn-sm" wire:click='save'/>
        </div>
     
    </div>
</div>