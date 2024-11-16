<?php

namespace App\Jobs;

use App\Models\CapitalBuildUp;
use App\Models\User;
use App\Services\Imports\Validations\CbuImportValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class CbuStoreJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $jobProcess;
    protected $data;
    public function __construct($data, $jobProcess)
    {
        //
        $this->data = $data;
        $this->jobProcess = $jobProcess;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $user = User::where('mid', $this->data['mid'])->first();

        $this->jobProcess->increment('processed_rows', 1);
        if (!(new CbuImportValidation($this->data))->validate()) {
            $this->jobProcess->increment('failed_rows');
            return;
        }



        CapitalBuildUp::updateOrCreate(
            [
                'user_id' => $user->id,
                'or_cdv' => $this->data['or_cdv'],
            ],
            [
                'date' => $this->data['date'],
                'amount_received' => $this->data['amount_received']
            ]

        );
    }
}
