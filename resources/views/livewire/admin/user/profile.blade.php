<?php

use Livewire\Volt\Component;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    use WithFileUploads;

    public User $user;
    public UserProfile $userprofile;

    public $photo;
    public $selectedTab='profile';

    public $form;


    public function mount()
    {
        $this->form = $this->user->profile->toArray();
    }


    public function save(){

        try{
            $this->user->profile->update($this->form);
            session()->flash('success','Profile Updated Successfully');
            $this->redirect(route('admin.users', absolute: false), navigate: true);

        }catch(\Exception $e){
            dd($e);

        }
    }

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
                        <x-input label="TIN (Tax Identification Number): " wire:model="form.tin_no" />
                    </div>
                    <br>
                    <hr>
                    <br>
                    <h6><b>I. Information on the Membership upon acceptance:</b></h6>
                    <br>
                    <div>
                        <x-datetime label="Date Accepted:" wire:model="form.date_accepted" icon="o-calendar"/>

                        <x-input label="Board of Directors (BOD) Resolution Number: " wire:model="form.acceptance_membership_bod_resolution_no" />
                
                        <x-input label="Type/Kind of Membership: " wire:model="form.type_of_membership" />
                  
                        <br>

                        <b><span class="text-base label-text">Initial Capital Subscription</span></b>

                        <x-input label="Number of Share: " wire:model="form.number_of_share" />
               
                        <x-input label="Amount: " wire:model="form.amount" />
                     
                        <x-input label="Initial Paid Up: " wire:model="form.initial_paid_up" />
                   

                    </div>
                    <br>
                    <h6><b>II. Membership Profile:</b></h6>
                    <br>
                    <x-input label="Address: " wire:model="form.address" />
            
                    <x-datetime label="Date of Birth:" wire:model="form.date_of_birth" icon="o-calendar"/>
              
                    <x-input label="Gender: " wire:model="form.gender" />
                 
                    <x-input label="Civil Status: " wire:model="form.civil_status" />
        
                    <x-input label="Highest Educational Attainment: " wire:model="form.highest_educational_attainment" />
               
                    <x-input label="Occupation/Income Source: " wire:model="form.occupation_income_source" />
                   
                    <x-input label="Number of Dependents:" wire:model="form.number_of_dependents" />
                   
                    <x-input label="Religion/Social Affiliation:" wire:model="form.religion_social_affiliation" />
                  

                    <x-input label="Annual Income:" wire:model="form.annual_income" />
                    


                    <hr>
                    <br>
                    <h6><b>III. Termination of Membership:</b></h6>
                    <br>
                    <x-input label="BOD Resolution Number:" wire:model="form.termination_membership_bod_resolution_no" />
                
                    <x-datetime label="Date:" wire:model="form.termination_membership_date" icon="o-calendar"/>
                    <br>
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


                <x-tab name="account_settings" label="Account Settings" icon="o-cog-6-tooth">
                    <livewire:components.account-settings :user_id='$user->id'/>
                </x-tab>

            </x-tabs>
                {{-- {{html_entity_decode($user->)}} --}}
            </div>
        </div>
    </div>
</div>
