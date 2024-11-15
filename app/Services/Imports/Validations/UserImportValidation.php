<?php

namespace App\Services\Imports\Validations;

use App\Enums\ImportCacheNameEnum;
use Illuminate\Support\Facades\Cache;
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
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'name' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            $this->row['errors'] = $errors;
            $failedRows = Cache::get(ImportCacheNameEnum::USER->value, []);
            $failedRows[] = $this->row; // Add current row to the array
            Cache::put(ImportCacheNameEnum::USER->value, $failedRows, 3600); // Save for 1 hour
            return false;
        }

        return true;
    }
}
