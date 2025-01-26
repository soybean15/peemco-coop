<?php

namespace App\Services\Imports\Validations;

use App\Contracts\WithImportValidation;
use App\Enums\ImportCacheNameEnum;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class CbuImportValidation implements WithImportValidation
{



    public $row;
    public function __construct(&$row)
    {

        $this->row = $row;
    }

    public function validate()
    {

        if (is_int($this->row['date'])) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($this->row['date']);
            $this->row['date'] = $date->format('Y-m-d'); // Convert to 'Y-m-d' format
        }

        $validator =  Validator::make($this->row, [
            'mid' => 'required',
            'or_cdv' => 'required',
            'amount_received' => 'required',
            'date'=>'required|date'
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            // dd($errors,$this->row);
            $this->row['errors'] = $errors;
            $failedRows = Cache::get(ImportCacheNameEnum::CBU->value, []);
            $failedRows[] = $this->row; // Add current row to the array
            Cache::put(ImportCacheNameEnum::CBU->value, $failedRows, 3600); // Save for 1 hour
            return false;
        }

        return true;
    }

    

}
