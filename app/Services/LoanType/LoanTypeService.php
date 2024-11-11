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

    public function getUsers($search=null){
        if(!$this->loanType){

            return User::query()->whereRaw('0 = 1');
        }
        if($this->loanType->apply_to == 'all'){
            return User::query();
        }
        return User::whereHas('loanTypes',function($query){

            $query->where('loan_type_id',$this->loanType->id);

        });
    }

    public function addUsers($user_ids){
        foreach($user_ids as $user_id){

            LoanTypeUser::create(['user_id'=>$user_id, 'loan_type_id'=>$this->loanType->id]);

        }
    }


    public  function store($data){




        $form = $data['form'];
        // dd($form['type']);

        $releaseDates = $data['releaseDates'];
        $rules = [
            'form.loan_type' => 'required|max:50',
            'form.maximum_amount' => 'required|numeric|gte:form.minimum_amount',
            'form.minimum_amount' => 'required|numeric',
            'form.charges' => 'required|numeric',
            'form.type' => 'required',

        ];
        $messages = [
            'form.loan_type.required' => 'The loan type is required.',
            'form.loan_type.max' => 'The loan type cannot exceed 50 characters.',
            'form.maximum_amount.required' => 'The maximum amount is required.',
            'form.maximum_amount.numeric' => 'The maximum amount must be a number.',
            'form.maximum_amount.gte' => 'The maximum amount must be greater than or equal to the minimum amount.',
            'form.minimum_amount.required' => 'The minimum amount is required.',
            'form.minimum_amount.numeric' => 'The minimum amount must be a number.',
            'form.charges.required' => 'Charges are required.',
            'form.charges.numeric' => 'Charges must be a number.',
            'form.type.required' => 'The type is required.',
            'form.annual_rate.required' => 'Annual rate is required.',
            'form.annual_rate.numeric' => 'Annual rate must be a number.',
            'form.penalty.required' => 'Penalty is required.',
            'form.penalty.numeric' => 'Penalty must be a number.',
            'form.grace_period.required' => 'Grace period is required.',
            'form.grace_period.numeric' => 'Grace period must be a number.',
            'releaseDates.*.start.required' => 'The start date is required for each release date.',
            'releaseDates.*.end.required' => 'The end date is required for each release date.',
        ];

        // Add conditional rules based on type
        if ($form['type'] == 'regular') {
            $rules['form.annual_rate'] = 'required|numeric';
            $rules['form.penalty'] = 'required|numeric';
            $rules['form.grace_period'] = 'required|numeric';
        } else {
            $rules['releaseDates.*.start'] = 'required';
            $rules['releaseDates.*.end'] = 'required';
        }

        Validator::make($data, $rules,$messages)->validate();

        // Run validation and handle failures



        $loanType =LoanType::create($form);
        if($data['type'] =='cash_advance'){
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
