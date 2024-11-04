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
    <div class="p-3 m-1 border-2 rounded shadow-md ">
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
                    <x-header title="{{html_entity_decode($user->name)}} {{html_entity_decode($user->middlename)}} {{html_entity_decode($user->lastname)}}" subtitle="{{$user->email}}" separator />
                    
                    
                    <div>
                        <label class="label">
                            <span class="text-base label-text">Member ID No:   <b>{{html_entity_decode($user->mid)}}</b></span>
                        </label>
            
                    </div>
                    <div>
                        <label class="label">
                            <span class="text-base label-text">TIN (Tax Identification Number):</span>
                        </label>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <h6><b>I. Information on the Membership upon acceptance:</b></h6>
                    <br>
                    <div>
                        <x-input label="Date Accepted: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text"></span>
                        </label>
            
                        <x-input label="Board of Directors (BOD) Resolution Number: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text">sample</span>
                        </label>
                    </div>
                    <div>
                        <label class="label">
                            <span class="text-base label-text">TIN (Tax Identification Number):</span>
                        </label>
                    </div>
                    <hr>
                    <h6><b>II. Membership Profile:</b></h6>

                    <hr>
                    <h6><b>III. Termination of Membership:</b></h6>
                    <div class="grid grid-cols-1 gap-2 md:grid-cols-2 ">





                        <x-input label="Contact Number" wire:model="form.contact_number" />
                        <x-input label="Address" wire:model="form.address" />
                        {{-- <x-input label="Prefix & Suffix" wire:model="name" />
                        <x-input label="Prefix & Suffix" wire:model="name"/> --}}
                    </div>
                    <div class="flex justify-end px-5">
                        <x-button label='Save' class="btn-primary btn-sm" wire:click='save'/>
                    </div>
                        
                </x-tab>

                <x-tab name="capital_build_up" label="Capital Build up" icon="o-arrow-trending-up">
                   <livewire:components.capital-build-up-list :user_id='$user->id'/>
                </x-tab>    

                <x-tab name="member_loan_list" label="Loans" icon="o-credit-card">
                   <livewire:components.member-loan-list :user_id='$user->id'/>
                </x-tab>  
                
        

            </x-tabs>
                {{-- {{html_entity_decode($user->)}} --}}
            </div>


        </div>


   

    </div>
</div>
