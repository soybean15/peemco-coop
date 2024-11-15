<?php

namespace App\Jobs;

use App\Enums\ImportCacheNameEnum;
use App\Events\ImportCompleted;
use App\Models\User;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class NotifyUserOfCompletedImport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $jobProcess;
    public function __construct($jobProcess, $user)
    {
        //
        $this->user = $user;
        $this->jobProcess= $jobProcess;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $failedRows = Cache::get(ImportCacheNameEnum::USER->value, []);

        $this->jobProcess->touch('completed_at');

        // dd('import complete');
    }
}
