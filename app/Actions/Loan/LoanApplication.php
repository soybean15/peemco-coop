<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;
use App\Helpers\IdGenerator;
use App\Models\Loan;
use App\Models\LoanItem;
use App\Models\LoanType;
use App\Providers\LoanServiceProvider;
use App\Services\LoanCalculator\LoanCalculator;
use App\Services\Loans\LoanService;
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
            'terms_in_year' => 'required|min:1',
            'other_charges' => 'nullable|min:0', // Optional field
            'monthly_payment' => 'required'
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
        $terms_in_year = $data['terms_in_year'];
        $terms_in_month= $data['terms_in_month'];

        $other_charges = $data['other_charges'] ?? 0;  // Default to 0 if not provided
        $monthly_payment = $data['monthly_payment'];
        $loanType= LoanType::find($data['loan_type_id']);

        // dd($loanType);

        if($principal > $loanType->maximum_amount){
            throw new \Exception("Maximum amount is $loanType->maximum_amount");

        }
        // dd($principal ,$loanType->minimum_amount);
        if($principal <$loanType->minimum_amount){
            throw new \Exception("Minimum amount is $loanType->minimum_amount");

        }


        if (empty($principal)) {
            throw new \Exception('No Principal amount');
        }


        $loanService = app(LoanCalculator::class);






        $loan = Loan::create(
            [
                'loan_application_no' => IdGenerator::generateId(LoanServiceProvider::LOAN_PREFIX, LoanServiceProvider::LOAN_LEN),
                'user_id' => $user_id,
                'loan_type_id'=>$loanType->id,
                'loan_type'=>$loanType->loan_type,
                'principal_amount' => $principal,
                'date_applied' => Carbon::now(),
                'no_of_installment' => $no_of_installment,
                // 'terms_in_year' => $terms_in_year,
                'other_charges' => $other_charges,
                'annual_interest_rate' => $annual_rate,
                'monthly_interest_rate' => $monthly_rate,
                'monthly_payment' => $monthly_payment,
                'status' => 'pending'
            ]
        );

        // $this->loanItems[]=[
        //     'period'=>$loanItem->getPeriod(),
        //     'interest'=>$loanItem->getInterest(),
        //     'principal'=>$loanItem->getPrincipal(),
        //     'net_proceed'=>$loanItem->getNetProceed(),
        //     'balance'=>$loanItem->getOutstandingBalance()
        // ];




        $loanService
            ->setLoanType($loanType->id)
            ->setPrincipal($principal)
            ->setTerms($terms_in_year,$terms_in_month)
            ->calculateLoan()
            ->getLoanItems(function ($loanItem,$dueDate)use ($loan) {


                LoanItem::create(
                    [
                        'loan_id'=>$loan->id,
                        'loan_period'=>$loanItem->getPeriod(),
                        'interest'  => $loanItem->getInterest(),
                        'amount_due'=>$loanItem->getNetProceed(),
                        'running_balance'=>$loanItem->getNetProceed(),
                        'status'=>'pending'

                    ]
                );
            });

        return $loan;
    }
}
