<?php

namespace App\Jobs;

use App\Helpers\IdGenerator;
use App\Models\User;
use App\Models\UserProfile;
use App\Providers\LoanServiceProvider;
use App\Services\Imports\Validations\UserImportValidation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Hash;

class UserStoreJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $data;
    public $jobProcess;
    public function __construct($data,$jobProcess)
    {
        //
        $this->data=$data;
        $this->jobProcess=$jobProcess;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //


        $this->jobProcess->increment('processed_rows',1);
       
        $row=$this->data;
        if(!(new UserImportValidation($row))->validate()){
            $this->jobProcess->increment('failed_rows');
            return ;
         }


        $user = User::create([
            'mid'      => IdGenerator::generateId(LoanServiceProvider::LOAN_PREFIX, LoanServiceProvider::LOAN_LEN),
            'name'     => $row['name'],
            'email'    => $row['email'],
            'username'=>    $row['username'],
            'lastname'=>$row['lastname'],
            'middlename'=>$row['middlename'],
            'extension'=>$row['extension']??'',
            'password' => Hash::make('password'),
        ]);

        if($user){
            UserProfile::firstOrCreate([
                'user_id'=>$user->id
            ]);
        }

    }
}
