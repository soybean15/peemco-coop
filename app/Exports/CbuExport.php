<?php

namespace App\Exports;

use App\Enums\ImportCacheNameEnum;
use Exception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CbuExport implements FromCollection, WithHeadings
{

    public $mode;
    public function __construct($mode='template'){


        $this->mode =$mode;
        // dd($this->mode);
    }
    public function collection()
    {


        switch ($this->mode) {
            case 'failed':

                try{

                    $data   = cache()->get(ImportCacheNameEnum::CBU->value);
                    return collect($data);

                }catch(Exception $e){


                    dd($e);
                }


            case 'template':
                return collect(
                    [
                        [
                        'mid'=>'MID-000009',
                        'date'=>'2022-12-30',
                        'or_cdv'=>'sample123',
                        'amount_received'=>1000
                    ]
                    ]
                );
            default:
        return collect(
            [
                [
                'mid'=>'MID-000009',
                'date'=>'2022-12-30',
                'or_cdv'=>'sample123',
                'amount_received'=>1000
            ]
            ]
            );
        }
    }
        public function headings(): array
    {
        return [
            'mid',
            'date',
            'or_cdv',
            'amount_received'
        ];
    }

}
