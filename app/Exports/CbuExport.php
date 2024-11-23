<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CbuExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
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
