<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedImport;
use App\Models\JobProcess;
use Illuminate\View\View;

new class extends Component {
    //
  use  WithFileUploads;
    public $file;

    public function rendering(View $view): void
    {
        $view->title('Admin - Import User');


    }
    public function import(){

        // dd($this->file);
        try {

        $jobProcess = JobProcess::create(
            [
                'user_id'=>Auth::id(),
                'process_for'=> 'user_import',
                'job_processable_type' =>User::class,
                'job_processable_id'=>Auth::id(),
                'processed_rows'=>0,
                'failed_rows'=>0



            ]
        );

        $import =new UsersImport($jobProcess);
        // dd($import->getRowCount());
        ($import)->queue($this->file)->chain([

            new NotifyUserOfCompletedImport($jobProcess,Auth::user()),
        ]);

        // $import = new UsersImport();
        // $import->import('testemail.xlsx');

        // dd($import->errors());        // (new UsersImport)->withOutput($this->output)->import('testemail.xlsx');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {



   }
    }

}; ?>

<div>


    <x-header title="User Import" subtitle="Drag or select you file" separator>

        <x-slot:middle class="!justify-end">
            <livewire:components.job-progress :processFor="'user_import'"/>

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


<script>

</script>
