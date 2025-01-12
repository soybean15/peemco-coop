<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
use Illuminate\View\View;

new class extends Component {
    use Toast;
    use WithFileUploads;

    public User $user;
    public UserProfile $userprofile;

    public $photo;
    public $selectedTab='profile';

    public $form;

    public function rendering(View $view): void
    {
        $view->title('Admin - Profile:'.$this->user->name);


    }
    public function mount()
    {


        $this->form = $this->user->profile->toArray();
    }

    public function updatedPhoto(){
        $this->user
        ->addMedia($this->photo)
        ->toMediaCollection('profile_photo');


    }




}; ?>
<div>
    <div class="p-3 m-1 rounded">
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

        <div class="flex flex-col justify-start md:flex-row">

            @if(session()->has('success'))
                <x-icon name="o-check" class="text-2xl text-green-500 w-9 h-9" label=" {{session('success')}}"/>
            @endif



            <div class="flex flex-col w-full px-5 md:p-5">
                <x-tabs wire:model="selectedTab">
                    <x-tab name="profile" label="Profile" icon="o-users">

                        <livewire:components.user-profile :user="$user"/>

                    </x-tab>

                <x-tab name="capital_build_up" label="Capital Build up" icon="o-arrow-trending-up">
                   <livewire:components.capital-build-up-list :user_id='$user->id'/>
                </x-tab>

                <x-tab name="member_loan_list" label="Loans" icon="o-credit-card">
                   <livewire:components.member-loan-list :user_id='$user->id'/>
                </x-tab>


                <x-tab name="account_settings" label="Account Settings" icon="o-cog-6-tooth">
                    <livewire:components.account-settings :user_id='$user->id'/>
                </x-tab>

            </x-tabs>
                {{-- {{html_entity_decode($user->)}} --}}
            </div>
        </div>
    </div>
</div>
