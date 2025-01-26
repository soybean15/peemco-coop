<?php

use Livewire\Volt\Component;
use App\Models\JobProcess;
use App\Models\CapitalBuildUp;
use App\Imports\CbuImport;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Jobs\NotifyUserOfCompletedImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CbuExport;
use Illuminate\View\View;

new class extends Component {
    use  WithFileUploads;
    public $file;


    public function rendering(View $view): void
    {
        $view->title('Admin - Import CBU');
        // dd('');
    //    dd( cache()->get('cbu_import'));


    }
    public function import(){

// dd($this->file);


            $jobProcess = JobProcess::create(
                [
                    'user_id'=>Auth::id(),
                    'process_for'=> 'cbu_import',
                    'job_processable_type' =>CapitalBuildUp::class,
                    'job_processable_id'=>Auth::id(),
                    'processed_rows'=>0,
                    'failed_rows'=>0



                ]
            );

            $import =new CbuImport($jobProcess);
            // dd($import->getRowCount());
            ($import)->queue($this->file)->chain([

                new NotifyUserOfCompletedImport($jobProcess,Auth::user()),
            ]);

            // $import = new UsersImport();
            // $import->import('testemail.xlsx');

            // dd($import->errors());        // (new UsersImport)->withOutput($this->output)->import('testemail.xlsx');
    }

    public function completeLoading(JobProcess $job){


        $job->touch('completed_at');

    }
    public function exportTemplate(){

        return Excel::download(new CbuExport, 'cbu.xlsx');
    }

}; ?>

<div>

    <x-header title="CBU import" subtitle="Drag or select you file" separator>

        <x-slot:middle class="!justify-end">

        <livewire:components.job-progress :processFor="'cbu_import'"/>
        </x-slot:middle>
        <x-slot:actions>
            @if($file)
            <x-button label="Import" class="btn-success" wire:click='import' />

            @endif
            <x-button label="Download Template" class="btn-ghost " wire:click='exportTemplate' />
        </x-slot:actions>
    </x-header>

    <div id="drop-area" class="flex justify-center p-20 bg-white border-2 border-dashed">

        <x-file wire:model.live="file" label="Drag file here" hint="Only PDF" accept="" />
    </div>

</div>
