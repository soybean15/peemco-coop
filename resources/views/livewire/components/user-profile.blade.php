<?php

use Livewire\Volt\Component;

use Mary\Traits\Toast;
new class extends Component {
    use Toast;

    public $user;
    public $form=[];
    public function mount($user){

        $this->user = $user;
        $this->form = $user->profile->toArray();
    }
    public function save(){

try{
    $this->user->profile->update($this->form);
    $this->success('Profile Updated Successfully');

    }catch(\Exception $e){
        dd($e);

    }
}
}; ?>

<div>
        <x-header
            title="{{html_entity_decode($user->name)}} {{html_entity_decode($user->middlename)}} {{html_entity_decode($user->lastname)}}"
            subtitle="{{$user->email}}" separator />

        <div>
            <label class="label">
                <span class="text-base label-text">Member ID No: <b>{{html_entity_decode($user->mid)}}</b></span>
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
            <x-datetime label="Date Accepted:" wire:model="form.date_accepted" icon="o-calendar" />

            <x-input label="Board of Directors (BOD) Resolution Number: "
                wire:model="form.acceptance_membership_bod_resolution_no" />

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

        <x-datetime label="Date of Birth:" wire:model="form.date_of_birth" icon="o-calendar" />

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

        <x-datetime label="Date:" wire:model="form.termination_membership_date" icon="o-calendar" />
        <br>
        <div class="flex justify-end px-5">
            <x-button label='Save' class="btn-primary btn-sm" wire:click='save' />
        </div>
</div>
