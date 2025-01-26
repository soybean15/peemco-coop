<?php

namespace App\Exports;

use App\Enums\ImportCacheNameEnum;
use Exception;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection,
WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

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

                    $data   = cache()->get(ImportCacheNameEnum::USER->value);
                    return collect($data);

                }catch(Exception $e){


                    dd($e);
                }


            case 'template':
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
            default:
                return collect(
                    [
                        [
                            'firstname' => 'Juan',
                            'middlename' => 'Santos',
                            'lastname' => 'Dela Cruz',
                            'username'=>'juan123',
                            'email' => 'juan.delacruz@example.com'
                        ]
                    ]
                );
        }
    }

        public function headings(): array
        {
            return [
                'firstname',
                'middlename',
                'lastname',
                'username',
                'email',
                'errors'
            ];
        }

}
