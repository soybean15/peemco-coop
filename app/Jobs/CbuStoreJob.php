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
        // dd('here');
        $this->data = $data;
        $this->jobProcess = $jobProcess;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //


        $this->jobProcess->increment('processed_rows', 1);

        if (!(new CbuImportValidation($this->data))->validate()) {
            $this->jobProcess->increment('failed_rows');
            return;
        }


        $user = User::where('mid', $this->data['mid'])->first();

        if (!$user) {
            $this->jobProcess->increment('failed_rows');
            return;
        }

        if (is_int($this->data['date'])) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->data['date']);
            $this->data['date'] = $date->format('Y-m-d'); // Convert to 'Y-m-d' format
        }


        CapitalBuildUp::updateOrCreate(
            [
                'user_id' => $user->id,
                'or_cdv' => $this->data['or_cdv'],
            ],
            [
                'date' => $this->data['date'],
                'amount_received' => $this->data['amount_received'],
                'added_by'=>$this->jobProcess->user_id
            ]

        );
    }
}
