<?php

namespace App\Actions\Import;

use App\Contracts\HasImport;
use App\Models\CapitalBuildUp;
use App\Models\User;
use App\Services\Imports\Validations\CbuImportValidation;
use Illuminate\Support\Facades\Auth;

class StoreCbu implements HasImport{



    public function store($data,$jobProcess=null){


        if (!(new CbuImportValidation($data))->validate()) {

            return;
        }


        $user = User::where('mid',$data['mid'])->first();

        if (!$user) {

            return;
        }

        if (is_int($data['date'])) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data['date']);
           $data['date'] = $date->format('Y-m-d'); // Convert to 'Y-m-d' format
        }


        CapitalBuildUp::updateOrCreate(
            [
                'user_id' => $user->id,
                'or_cdv' =>$data['or_cdv'],
            ],
            [
                'date' =>$data['date'],
                'amount_received' =>$data['amount_received'],
                'added_by'=>$jobProcess->user_id
            ]

        );

    }
}
