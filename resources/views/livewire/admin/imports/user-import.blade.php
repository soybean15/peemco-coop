<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedImport;

new class extends Component {
    //
  use  WithFileUploads;
    public $file;

    public function import(){

        // dd($this->file);
        try {
        $import =new UsersImport;
        ($import)->queue($this->file)->chain([

            new NotifyUserOfCompletedImport($import,Auth::user()),
        ]);

        // $import = new UsersImport();
        // $import->import('testemail.xlsx');

        // dd($import->errors());        // (new UsersImport)->withOutput($this->output)->import('testemail.xlsx');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {



   }
    }
}; ?>

<div>
    <x-header title="User Import" subtitle="Drag or select you file" separator />
        <div id="drop-area"
        class="flex justify-center p-20 bg-white border-2 border-dashed"
      >

    <x-file wire:model.live="file" label="Drag file here" hint="Only PDF" accept="" />
        </div>

        @if($file)
        <x-button label="Import" class="btn-success" wire:click='import'/>

        @endif

</div>


<script>

</script>
