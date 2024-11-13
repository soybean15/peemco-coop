<?php

namespace App\Imports;

use App\Helpers\IdGenerator;
use App\Models\User;
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
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
class UsersImport implements ToModel, WithHeadingRow, WithProgressBar, WithChunkReading,  ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable,SkipsErrors;
    public function model(array $row)
    {


         if(!(new UserImportValidation($row))->validate()){
            return ;
         }

        // if()
        return new User([
            'mid'      => IdGenerator::generateId(LoanServiceProvider::LOAN_PREFIX, LoanServiceProvider::LOAN_LEN),
            'name'     => $row['name'],
            'email'    => $row['email'],
            'username'=>$row['username'],
            'password' => Hash::make('password'),
        ]);
    }

    public function headingRow(): int
    {
        return 1;
    }



    // public function rules(): array
    // {
    //     return [
    //         'email' => 'required|email|unique:users,email',
    //         'username' => 'required|unique:users,username',
    //         'name' => 'required'
    //     ];
    // }


    public function chunkSize(): int
    {
        return 50;
    }
    // public function registerEvents(): array
    // {
    //     return [
    //         ImportFailed::class => function(ImportFailed $event) {

    //             dd('here');
    //         },
    //     ];
    // }


    // public function onFailure(Failure ...$failures)
    // {
    //     // Collect failed rows and error messages
    //     dd($failures);

    // }


}
