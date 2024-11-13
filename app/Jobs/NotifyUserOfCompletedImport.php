<?php

namespace App\Jobs;

use App\Enums\ImportCacheNameEnum;
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
    protected $import;
    public function __construct($import, $user)
    {
        //
        $this->user = $user;
        $this->import= $import;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $failedRows = Cache::get(ImportCacheNameEnum::USER->value, []);
        dd($failedRows);
        // dd('import complete');
    }
}
