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

    public $user_id;
    public $tinNo;
    public $dateAccepted;

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
                        <label class="label">
                            <span class="text-base label-text">:123145</span>
                        </label>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <h6><b>I. Information on the Membership upon acceptance:</b></h6>
                    <br>
                    <div>
                        <x-datetime label="Date Accepted:" wire:model="form.date_accepted" icon="o-calendar"/>
                        <label class="label">
                            <span class="text-base label-text"></span>
                        </label>

                        <x-input label="Board of Directors (BOD) Resolution Number: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text">sample</span>
                        </label>

                        <x-input label="Type/Kind of Membership: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text">sample</span>
                        </label>

                        <br>
                        <b><span class="text-base label-text">Initial Capital Subscription</span></b>
                        <x-input label="Number of Share: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text">sample</span>
                        </label>

                        <x-input label="Amount: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text">sample</span>
                        </label>

                        <x-input label="Initial Paid Up: " wire:model="form.contact_number" />
                        <label class="label">
                            <span class="text-base label-text">sample</span>
                        </label>


                    </div>

                    <h6><b>II. Membership Profile:</b></h6>

                    <x-input label="Address: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Date of Birth: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Age: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Gender: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Civil Status: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Highest Educational Attainment: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Occupation/Income Source: " wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Number of Dependents:" wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Religion/Social Affiliation:" wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Annual Income:" wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>


                    <hr>
                    <br>
                    <h6><b>III. Termination of Membership:</b></h6>
                    <br>
                    <x-input label="BOD Resolution Number:" wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>

                    <x-input label="Date:" wire:model="form.contact_number" />
                    <label class="label">
                        <span class="text-base label-text">sample</span>
                    </label>


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
