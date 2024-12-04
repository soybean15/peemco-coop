<?php

namespace App\Actions\Payment;

use App\Contracts\HasLoanPayment;
use App\Models\LoanPayment as ModelsLoanPayment;
use Illuminate\Support\Facades\Auth;

class LoanPayment implements HasLoanPayment{


    public function handle($data):ModelsLoanPayment{


        $amount = $data['amount'];
        $or_cdv = $data['or_cdv'];
        $date = $data['date'];


        $loanItem = $data['loan_item'];
        $loan = $data['loan'];


       $payment= $loanItem->payments()->create([
            'amount_paid'=>$amount,
            'added_by'=>Auth::id(),
            'or_cdv'=>$or_cdv,
            'loan_id'=>$loanItem->loan?->id ??$loan->id,
            'date'=>$date

        ]);
        // $payment = ModelsLoanPayment::create([
        //     'amount_paid'=>$amount,
        //     'added_by'=>Auth::id(),
        //     'or_cdv'=>$or_cdv,
        //     'loan_id'=>$loanItem->loan?->id ??$loan->id,
        //     'loan_item_id'=>$loanItem?->id,
        //     'date'=>$date

        // ]);


        if($loanItem)
        {
            $loanItem->amount_paid += $amount;
            $loanItem->running_balance-=$amount;

            if(  $loanItem->running_balance==0){
                $loanItem->status='paid';
            }
            $loanItem->save();
        }


        return $payment;
    }
}
