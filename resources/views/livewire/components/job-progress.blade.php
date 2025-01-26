<?php

use Livewire\Volt\Component;
use App\Models\JobProcess;

use Livewire\Attributes\Computed;
use App\Services\Excel\ExcelService;
new class extends Component {

    public $processFor;

    public $failedImports;

    public $hasFailed;

    public function mount($processFor){
        $this->processFor = $processFor;

    }

    public function getCache(){
        $this->failedImports= cache()->get($this->processFor);


        if ($this->failedImports && count($this->failedImports)>0){


            // dd( $this->failedImports);
            $this->hasFailed=true;
        }
    }

    #[Computed]
    public function imports(){

        return auth()->user()->onGoingImports()->where('process_for',$this->processFor);
    }

    public function completeLoading(JobProcess $job){

        $job->touch('completed_at');
    }

    public function downloadFailedImports(){

        return (new ExcelService($this->processFor))->downloadFailed();
    }

    public function clearCache(){
        cache()->forget($this->processFor);
        $this->hasFailed=false;
    }
}; ?>

<div>


    <div wire:poll.1s>

        @foreach ($this->imports as $import)

        <x-progress-radial value="{{  $import->percentage() }}" wire:click='completeLoading({{ $import }})'/>

        @endforeach



    </div>

    <div wire:poll.1s="getCache">


    </div>
    {{-- {{   $this->failedImports }} --}}
    {{-- {{$processFor }} --}}
    @if ($hasFailed)
        <div class="relative flex items-center px-4 py-3 text-sm text-red-700 bg-red-100 border border-red-400 rounded" role="alert">

            <span class="block sm:inline">Some imports have failed. Please check!</span>
            <div class="mx-2 ">
                <button
                    wire:click="downloadFailedImports"
                    class="px-3 py-1 font-bold text-white bg-blue-700 rounded ">
                    Download
                </button>
                <button
                wire:confirm='Are you sure you want to clear failed imports?'
                wire:click="clearCache"
                class="px-3 py-1 font-bold text-white bg-red-600 rounded hover">
                Clear
            </button>
            </div>
        </div>

    @endif
</div>
