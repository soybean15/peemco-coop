<?php

namespace App\Services\Imports\Validations;

use Illuminate\Support\Facades\Validator;

class UserImportValidation
{


    public $row;
    public function __construct($row)
    {

        $this->row = $row;
    }

    public function validate()
    {


        $validator =  Validator::make($this->row, [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            //save in cache

            return false;
        }


        return true;
    }
}
