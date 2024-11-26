<?php

namespace App\Imports;

use App\Helpers\IdGenerator;
use App\Jobs\UserStoreJob;
use App\Models\JobProcess;
use App\Models\User;
use App\Models\UserProfile;
use App\Notifications\ImportHasFailedNotification;
use App\Providers\LoanServiceProvider;
use App\Services\Imports\Validations\UserImportValidation;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Events\ImportFailed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Events\BeforeImport;

class UsersImport implements ToModel, WithHeadingRow, WithProgressBar, WithChunkReading,  ShouldQueue,WithEvents
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable,SkipsErrors;


    public $jobProcess ;
    public function __construct($jobProcess){


        $this->jobProcess=$jobProcess;
    }
    public function model(array $row)
    {


         dispatch(new UserStoreJob($row,$this->jobProcess));

        // if()

    }

    public function headingRow(): int
    {
        return 1;
    }





    public function chunkSize(): int
    {
        return 50;
    }

    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $totalRows = $event->getReader()->getTotalRows();
                // dd($totalRows['Form responses 1']);
                $value = reset($totalRows);

                $this->jobProcess->update(['total_rows'=>$value]);
                // dd($this->jobProcess);

            },
        ];
    }


}
