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
<div class="p-6 bg-white rounded-lg shadow-md">

    <!-- TIN Input -->
    <div class="grid grid-cols-2 gap-5 my-5">
        <x-input label="TIN (Tax Identification Number):" wire:model="form.tin_no" class="input-md" placeholder="Enter valid Tin number" />
    </div>

    <!-- Section I: Information on the Membership -->
    <strong class="text-lg font-semibold">I. Information on the Membership upon Acceptance:</strong>

    <div class="flex flex-col my-5 space-y-5">

        <div class="grid grid-cols-2 gap-5">
            <x-datetime label="Date Accepted:" wire:model="form.date_accepted" icon="o-calendar" />
            <x-input label="Board of Directors (BOD) Resolution Number:" wire:model="form.acceptance_membership_bod_resolution_no" placeholder="Enter Resolution Number" />
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input label="Type/Kind of Membership:" wire:model="form.type_of_membership" placeholder="Enter Type of membership" />
        </div>

        <!-- Initial Capital Subscription -->
        <span class="text-base font-bold label-text">Initial Capital Subscription</span>

        <div class="grid grid-cols-2 gap-5 my-5">
            <x-input label="Number of Shares:" wire:model="form.number_of_share" placeholder="Enter Number of shares" />
            <x-input label="Amount:" wire:model="form.amount" type="number" placeholder="Enter Amount" />
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input label="Initial Paid Up:" wire:model="form.initial_paid_up" type="number" placeholder="Enter Initial paid up" />
        </div>

    </div>

    <!-- Section II: Membership Profile -->
    <span class="text-base font-bold label-text">II. Membership Profile:</span>

    <div class="flex flex-col my-5 space-y-5">

        <div class="grid grid-cols-2 gap-5 my-5">
            <x-input label="Address:" wire:model="form.address" />
            <x-datetime label="Date of Birth:" wire:model="form.date_of_birth" icon="o-calendar" />
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input label="Gender:" wire:model="form.gender" />
            <x-input label="Civil Status:" wire:model="form.civil_status" />
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input label="Highest Educational Attainment:" wire:model="form.highest_educational_attainment" />
            <x-input label="Occupation/Income Source:" wire:model="form.occupation_income_source" />
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input label="Number of Dependents:" wire:model="form.number_of_dependents" />
            <x-input label="Religion/Social Affiliation:" wire:model="form.religion_social_affiliation" />
        </div>

        <div class="grid grid-cols-2 gap-5">
            <x-input label="Annual Income:" wire:model="form.annual_income" />
        </div>

    </div>

    <!-- Section III: Termination of Membership -->
    <span class="text-base font-bold label-text">III. Termination of Membership:</span>

    <div class="flex flex-col my-5 space-y-5">
        <div class="grid grid-cols-2 gap-5">
            <x-input label="BOD Resolution Number:" wire:model="form.termination_membership_bod_resolution_no" />
            <x-datetime label="Date:" wire:model="form.termination_membership_date" icon="o-calendar" />
        </div>
    </div>

    <!-- Save Button -->
    <div class="flex justify-end px-5 mt-6">
        <x-button label="Save" class="btn-success btn-md" wire:click="save" />
    </div>

</div>
