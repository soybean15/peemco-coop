<?php

namespace App\Imports;

use App\Helpers\IdGenerator;
use App\Models\User;
use App\Providers\AppServiceProvider;
use App\Providers\LoanServiceProvider;
use App\Services\Imports\Validations\UserImportValidation;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithProgressBar
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use Importable;
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

}
