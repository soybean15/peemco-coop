<?php

namespace App\Services\LoanType;

use App\Models\LoanReleaseDate;
use App\Models\LoanType;
use Illuminate\Support\Facades\Validator;

class LoanTypeService{

    public $loanType;
    public function __construct($loanType=null){

        $this->loanType = $loanType;
    }


    public  function store($data){

        $type=$data['type'];

        $rules = [
            'form.loan_type' => 'required|max:50',
            'form.maximum_amount' => 'required|numeric|gte:form.minimum_amount',
            'form.minimum_amount' => 'required|numeric',
            'form.charges' => 'required|numeric',
        ];

        // Add conditional rules based on type
        if ($type == 'regular') {
            $rules['form.annual_rate'] = 'required|numeric';
        } else {
            $rules['releaseDates.*.start'] = 'required';
            $rules['releaseDates.*.end'] = 'required';
        }

        Validator::make($data, $rules)->validate();

        // Run validation and handle failures

        $form = $data['form'];
        $releaseDates = $data['releaseDates'];

        $type = $data['type'];

        $loanType =LoanType::create($form);
        if($type =='cash_advance'){
            if(count($releaseDates)>0){

                foreach ($releaseDates as $date) {
                    LoanReleaseDate::create(
                        [
                            'loan_type_id'=>$loanType->id,
                            'from'=>$date['start'],
                            'to'=>$date['end']
                            ]
                );
                    # code...
                }

            }
        }
    }



    public  function update($form){
        $this->loanType->update($form);
    }
}
