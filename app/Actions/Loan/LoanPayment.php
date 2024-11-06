<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;
use App\Models\Loan;
use App\Models\LoanPayment as ModelsLoanPayment;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanPayment implements HasLoan
{

    public function handle($data): Loan{

        $amount = $data['amount'];
        $or_cdv = $data['or_cdv'];


        $loanItem = $data['loan_item'];

        ModelsLoanPayment::create([
            'amount_paid'=>$amount,
            'added_by'=>Auth::id(),
            'or_cdv'=>$or_cdv,
            'loan_id'=>$loanItem->loan->id,
            'loan_item_id'=>$loanItem->id,
            'date'=>Carbon::now()

        ]);

        $loanItem->amount_paid += $amount;
        $loanItem->running_balance-=$amount;

        if(  $loanItem->running_balance==0){
            $loanItem->status=='paid';
        }
        $loanItem->save();

        return $loanItem->loan;
    }

}
