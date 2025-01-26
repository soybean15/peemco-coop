<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,
WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(
            [
            [
            'firstname' => 'Juan',
            'middlename' => 'Santos',
            'lastname' => 'Dela Cruz',
            'email' => 'juan.delacruz@example.com'
            ]
            ]
        );
    }

        public function headings(): array
        {
            return [
                'firstname',
                'middlename',
                'lastname',
                'email'
            ];
        }

}
