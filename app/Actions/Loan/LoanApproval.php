<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;

use App\Models\Loan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanApproval implements HasLoan

{




    public function handle($data): Loan
    {

        $loan = $data['loan'];

        if($loan->remarks=='renewal'){
           $user = $loan->user;
           $user->loans()->each(function($item  ){

            $item->where('status','approved')->update(['remarks'=>'completed']);
           });
        }
        $loan->update(
            [
                'status'=>'approved',
                'confirmed_by'=>Auth::id(),
                'date_confirmed'=>Carbon::today()
        ]);


        $dueDate = Carbon::now()
        ->addMonth()
        // ->subMonths(1)
        ;


        $loan->items->each(function($item)use ($dueDate){

            $item->update(['due_date'=>$dueDate]);
            $dueDate->addMonth();


        });


        // $today = Carbon::now()->format('m-d');
        // $releaseDates = $loan->loanType->releaseDates;
        // // dd($releaseDates);

        // $matchingDate = collect($releaseDates)->first(function ($date) use ($today) {
        //     return $today >= $date['from'] && $today <= $date['to'];
        // });


        // if ($matchingDate) {


        //     $date =date('Y') .'-'. $matchingDate->to;

        // } else {
        //     // No matching release date found
        //    throw new \Exception('Invalid Date');
        // }


        // $loan->cashAdvanceItems()->create([
        //     'due_date'=>$date,
        //     'charge_amount'=>$loan->other_charges,
        //     'amount_to_pay'=>$loan->principal_amount

        // ]);





        //create Loan Items
        return $loan;
    }

}
