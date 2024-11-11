<?php

use Livewire\Volt\Component;
use App\Services\Settings\GeneralSettingsService;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    use WithFileUploads;
    public $form=[];
    public $settings;
    public $logo;
    public function mount(){

        try{
            $service = app(GeneralSettingsService::class);

            $this->settings = $service->getSettings();
            $this->form =$this->settings->toArray();

        }catch(\Exception $e){
            dd($e);
        }

    }


    public function save(){

        $this->validate([
            'form.company_name'=>'required',
            'form.address'=>'required'
    ]);

    $this->success("Settings Updated");
    $this->settings->update($this->form);

    }


    public function updatedLogo(){


        $this->settings->addMedia($this->logo)
        ->toMediaCollection('logo');
    }
}; ?>

<div>
    <x-header title="General Settings" subtitle="" size="text-xl" separator />


    <div class="grid grid-cols-1 md:grid-cols-2">



    <x-form wire:submit="save" class="">

        <x-file wire:model.live="logo" accept="image/png, image/jpeg" class="my-3">
            <img src="{{ $settings->logo ?? '/default/default-logo.png' }}" class="h-40 rounded-lg" />
        </x-file>
        <x-input label="Company Name" wire:model="form.company_name" />
        <x-input label="Address" wire:model="form.address" />


        <x-slot:actions>
            <x-button label="Cancel" />
            <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-form>
    </div>
</div>
