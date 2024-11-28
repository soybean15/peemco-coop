<?php

use Livewire\Volt\Component;
use App\Models\JobProcess;

use Livewire\Attributes\Computed;

new class extends Component {

    public $processFor;

    public function mount($processFor){
        $this->processFor = $processFor;

    }

    #[Computed]
    public function imports(){

        return auth()->user()->onGoingImports()->where('process_for',$this->processFor);
    }

    public function completeLoading(JobProcess $job){

        $job->touch('completed_at');
    }
}; ?>

<div>
    <div wire:poll.1s>

        @foreach ($this->imports as $import)

        <x-progress-radial value="{{  $import->percentage() }}" wire:click='completeLoading({{ $import }})'/>

        @endforeach

    </div>
</div>
