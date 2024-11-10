<?php

namespace App\Services\LoanType;

use App\Models\LoanReleaseDate;
use App\Models\LoanType;
use App\Models\LoanTypeUser;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class LoanTypeService{

    public $loanType;
    public function __construct($loanType=null){

        $this->loanType = $loanType;
    }

    public function getUsersExcept(){

       // Ensure $this->loanType is set before running the query
            if (!$this->loanType) {

                return User::query(); // Return an empty collection if no loanType is set
            }

        // Retrieve users who don't have this specific loanType
        return User::whereDoesntHave('loanTypes', function ($query) {
            $query->where('loan_type_id', $this->loanType->id);
        });
    }


    public function addUsers($user_ids){
        foreach($user_ids as $user_id){

            LoanTypeUser::create(['user_id'=>$user_id, 'loan_type_id'=>$this->loanType->id]);

        }
    }


    public  function store($data){

        $type=$data['type'];
        $form['type']=$type;


        $rules = [
            'form.loan_type' => 'required|max:50',
            'form.maximum_amount' => 'required|numeric|gte:form.minimum_amount',
            'form.minimum_amount' => 'required|numeric',
            'form.charges' => 'required|numeric',
        ];

        // Add conditional rules based on type
        if ($type == 'regular') {
            $rules['form.annual_rate'] = 'required|numeric';
            $rules['form.penalty'] = 'required|numeric';
            $rules['form.grace_period'] = 'required|numeric';
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

        session()->put('loan_type_id',$loanType->id);

    }



    public  function update($form){
        // dd($form);


        $this->loanType->update($form);
    }
}
