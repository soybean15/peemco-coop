<?php

namespace App\Actions\Payment;

use App\Contracts\HasLoanPayment;
use App\Models\LoanPayment;
use Illuminate\Support\Facades\Auth;

class CashAdvancePayment implements HasLoanPayment{


    public function handle($data):LoanPayment{


        $amount = $data['amount'];
        $or_cdv = $data['or_cdv'];
        $date = $data['date'];


        $cashAdvanceItem = $data['loan_item'];
        $loan = $data['loan'];
        // dd($cashAdvanceItem);

        $payment= $cashAdvanceItem->payments()->create([
            'amount_paid'=>$amount,
            'added_by'=>Auth::id(),
            'or_cdv'=>$or_cdv,
            'loan_id'=>$cashAdvanceItem->loan?->id ??$loan->id,
            'date'=>$date

        ]);

        if($cashAdvanceItem)
        {
            // $cashAdvanceItem->amount_paid += $amount;
            // $cashAdvanceItem->running_balance-=$amount;

            // dd($amount,$cashAdvanceItem->charge_amount,$amount >= $cashAdvanceItem->charge_amount);
            if( $amount >= $cashAdvanceItem->charge_amount){
                $cashAdvanceItem->status='paid';
                $cashAdvanceItem->save();
            }

        }


        return $payment;
    }
}
