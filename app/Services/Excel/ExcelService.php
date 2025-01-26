<?php

namespace App\Services\Excel;

use App\Enums\ImportCacheNameEnum;
use App\Exports\CbuExport;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;


class ExcelService
{

    public $processFor;
    public function __construct($processFor)
    {
        $this->processFor =$processFor;
        // Initialization code here
    }

    public function downloadFailed(){
        // return Excel::download(new UsersExport, 'user.xlsx');

        // dd($this->processFor,ImportCacheNameEnum::USER->value);
        switch($this->processFor){


            case ImportCacheNameEnum::USER->value:
// dd( Excel::download(new UsersExport('failed'), 'user-failed.xlsx'));
                return Excel::download(new UsersExport('failed'),
                 'user-failed.xlsx');

            case ImportCacheNameEnum::CBU->value:
                return Excel::download(new CbuExport, 'user-failed.xlsx');

        }
    }

    public function import($filePath)
    {
        // Code to import Excel file
    }

    public function export($data, $filePath)
    {
        // Code to export data to Excel file
    }



    // Add more methods as needed
}
