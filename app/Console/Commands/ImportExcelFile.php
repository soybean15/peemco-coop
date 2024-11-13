<?php

namespace App\Console\Commands;

use App\Imports\UsersImport;
use App\Jobs\NotifyUserOfCompletedImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class ImportExcelFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:excel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $this->output->title('Starting import');

        try {
        $import =new UsersImport;
        ($import)->queue('testemail.xlsx')->chain([

            new NotifyUserOfCompletedImport($import,Auth::user()),
        ]);

        // $import = new UsersImport();
        // $import->import('testemail.xlsx');

        // dd($import->errors());        // (new UsersImport)->withOutput($this->output)->import('testemail.xlsx');
    } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
        $failures = $e->failures();


        foreach ($failures as $failure) {
            $failure->row(); // row that went wrong
            // $this->output->success( $failure->row());
            $failure->attribute(); // either heading key (if using heading row concern) or column index
            $failure->errors(); // Actual error messages from Laravel validator
            $failure->values(); // The values of the row that has failed.
        }
   }
        $this->output->success('Import successful');
    }
}
