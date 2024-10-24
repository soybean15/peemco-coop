<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;
use App\Helpers\IdGenerator;
use App\Models\Loan;
use App\Providers\LoanServiceProvider;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class LoanApplication implements HasLoan
{

    public function handle($data): Loan
    {

        $validator = Validator::make($data, [
            'monthly_rate' => 'required|min:0',
            'annual_rate' => 'required|min:0',
            'principal' => 'required|min:0',
            'user_id' => 'required|integer|exists:users,id', // Ensure user exists in the users table
            'no_of_installment' => 'required|integer|min:1',
            'terms_of_loan' => 'required|min:1',
            'other_charges' => 'nullable|min:0', // Optional field
            'monthly_payment'=>'required'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }



        // Continue with your logic if validation passes
        $monthly_rate = $data['monthly_rate'];
        $annual_rate = $data['annual_rate'];
        $principal = $data['principal'];
        $user_id = $data['user_id'];
        $no_of_installment = $data['no_of_installment'];
        $terms_of_loan = $data['terms_of_loan'];
        $other_charges = $data['other_charges'] ?? 0;  // Default to 0 if not provided
        $monthly_payment = $data['monthly_payment'];

        return Loan::create(
            [
                'loan_application_no'=>IdGenerator::generateId(LoanServiceProvider::LOAN_PREFIX, 7),
                'user_id' => $user_id,
                'principal_amount' => $principal,
                'date_applied' => Carbon::now(),
                'no_of_installment' => $no_of_installment,
                'terms_of_loan' => $terms_of_loan,
                'other_charges' => $other_charges,
                'annual_interest_rate' => $annual_rate,
                'monthly_interest_rate' => $monthly_rate,
                'monthly_payment'=>$monthly_payment,
                'status' => 'pending'
            ]
        );
    }
}
