<?php

use Livewire\Volt\Component;

new class extends Component {
    public $file;
}; ?>

<div>

    <x-header title="CBU import" subtitle="Drag or select you file" separator>

        <x-slot:middle class="!justify-end">
            <div wire:poll.1s>

                @foreach ( auth()->user()->onGoingImports() as $import)

                <x-progress-radial value="{{  $import->percentage() }}" />
                {{-- {{ $import->processed_rows }}/
                {{ $import->total_rows }} --}}
                @endforeach

            </div>
        </x-slot:middle>
        <x-slot:actions>
            @if($file)
            <x-button label="Import" class="btn-success" wire:click='import' />

            @endif

        </x-slot:actions>
    </x-header>

    <div id="drop-area" class="flex justify-center p-20 bg-white border-2 border-dashed">

        <x-file wire:model.live="file" label="Drag file here" hint="Only PDF" accept="" />
    </div>

</div>
