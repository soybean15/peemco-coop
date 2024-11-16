<?php

namespace App\Imports;

use App\Jobs\CbuStoreJob;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithProgressBar;
use Maatwebsite\Excel\Events\BeforeImport;

class CbuImport implements  ToModel, WithHeadingRow, WithProgressBar, WithChunkReading,  ShouldQueue,WithEvents
{
    /**
    * @param Collection $collection
    */

    use Importable,SkipsErrors;
    public $jobProcess ;
    public function __construct($jobProcess){

        $this->jobProcess=$jobProcess;
    }

    public function model(array $row)
    {


        // dd($row);
         dispatch(new CbuStoreJob($row,$this->jobProcess));

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

                $value = reset($totalRows);
                // dd($value);
                // dd($totalRo;ws['Form responses 1']);
                $this->jobProcess->update(['total_rows'=>$value]);

                // dd($this->jobProcess);

            },
        ];
    }

}
