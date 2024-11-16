<?php

namespace App\Imports;

use App\Jobs\CbuStoreJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CbuImport implements ToCollection,ShouldQueue,WithHeadingRow,WithChunkReading
{
    /**
    * @param Collection $collection
    */
    public $jobProcess ;
    public function __construct($jobProcess){

        $this->jobProcess=$jobProcess;
    }
    public function collection(Collection $collection)
    {
        foreach ($collection as $row)
        {
           dispatch(new CbuStoreJob($row,$this->jobProcess));
        }
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function chunkSize(): int
    {
        return 50;
    }

}
