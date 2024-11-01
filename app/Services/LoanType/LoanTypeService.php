<?php

namespace App\Services\LoanType;

use App\Models\LoanReleaseDate;
use App\Models\LoanType;


class LoanTypeService{


    public static function store($data){


        $form = $data['form'];
        $releaseDates = $data['releaseDates'];

        $type = $data['type'];
        LoanType::create($form);
        if($type =='cash_advance'){
            if(count($releaseDates)>0){

                foreach ($releaseDates as $date) {
                    LoanReleaseDate::create(
                        ['from'=>$date['start'],'to'=>$date['end']]
                );
                    # code...
                }

            }
        }
    }



    public static function update($form){

    }
}
