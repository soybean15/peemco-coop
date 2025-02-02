<?php

use Livewire\Volt\Component;
use App\Services\Settings\GeneralSettingsService;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use Mary\Traits\Toast;
new class extends Component {
    use Toast;
    use WithFileUploads;
    public $form=[];
    public $settings;
    public $logo;
    public $mission;
    public $vision;


    public function mount(){

        try{
            $service = app(GeneralSettingsService::class);

            $this->settings = $service->getSettings();
            $this->form =$this->settings->toArray();
            $this->mission = $this->settings->mission;
            $this->vision = $this->settings->vision;
            //dd($this->settings);


        }catch(\Exception $e){
            dd($e);
        }

    }


    #[On('updated-editor')]
    public function onUpdateEditor($model, $value){


        // dd($model);
        if($model=='vision'){

            $this->vision = $value;

        }else {
            // dd($value);
            $this->mission = $value;
        }



    }


    public function save(){
        // dd($this->mission,$this->vision);


        $this->validate([
            'form.company_name'=>'required',
            'form.address'=>'required'
            ]);

        $this->form['vision']=$this->vision;
        $this->form['mission']=$this->mission;
        $this->success("Settings Updated");
        $this->settings->update($this->form);

    }


    public function updatedLogo(){



        $this->settings->addMedia($this->logo)
        ->toMediaCollection('logo');


    }
}; ?>

<div class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <x-header title="General Settings" subtitle="" size="text-xl" separator />

    <x-form wire:submit="save" class="space-y-8">
        <div class="flex flex-col md:flex-row md:space-x-6">
            <!-- Logo Section -->
            <div class="md:w-1/3 flex flex-col items-center">
                <x-file wire:model.live="logo" accept="image/png, image/jpeg" class="mb-4">
                    <img src="{{ $settings->logo ?? '/default/default-logo.png' }}"
                         class="h-40 w-40 object-cover rounded-lg border border-gray-200 shadow-sm"
                         alt="Company Logo" />
                </x-file>
                <p class="text-xs text-gray-500">Upload a new logo</p>
            </div>
            <!-- Company Info Section -->
            <div class="md:w-2/3 space-y-4">
                <x-input label="Company Name" wire:model="form.company_name" class="w-full" />
                <x-input label="Address" wire:model="form.address" class="w-full" />
            </div>
        </div>

        <!-- Rich Text Editors Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div wire:ignore>
                <x-rich-text-editor model="mission" value="{{ $mission }}" key="m" />
            </div>
            <div wire:ignore>
                <x-rich-text-editor model="vision" value="{{ $vision }}" key="v" />
            </div>
        </div>

        <!-- Form Actions -->
        <x-slot:actions>
            <div class="flex justify-end space-x-4">
                <x-button label="Cancel" class="btn-secondary" />
                <x-button label="Save" class="btn-primary" type="submit" spinner="save" />
            </div>
        </x-slot:actions>
    </x-form>
</div>
