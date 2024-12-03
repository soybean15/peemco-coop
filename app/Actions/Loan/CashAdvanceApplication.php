<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;
use App\Helpers\IdGenerator;
use App\Models\Loan;
use App\Models\LoanType;
use App\Providers\LoanServiceProvider;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CashAdvanceApplication implements HasLoan{


    public function handle($data): Loan
    {
        // dd('here');
        $loanType = LoanType::find($data['loan_type_id']);
        $user_id = $data['user_id'];
        $principal = $data['principal'];
        $other_charges = $data['charge_amount'];


        $validator = Validator::make($data, [


            'principal' => 'required|numeric|min:0',
            'user_id' => 'required|integer|exists:users,id',
            'other_charges' => 'nullable|numeric|min:0',
            'due_date'=>'required'
        ]);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $loan = Loan::create(
            [
                'loan_application_no' => IdGenerator::generateId(LoanServiceProvider::LOAN_PREFIX, LoanServiceProvider::LOAN_LEN),
                'user_id' => $user_id,
                'loan_type_id'=>$loanType->id,
                'loan_type'=>$loanType->loan_type,
                'principal_amount' => $principal,
                'date_applied' => Carbon::now(),
                'other_charges' => $other_charges,
                'status' => 'pending'
            ]
        );

        $loan->cashAdvanceItems()->create([
            'amount_to_pay' => $principal,
            'charge_amount' =>$other_charges,
            'due_date' => $data['due_date'],

        ]);





        return $loan;


    }


}
