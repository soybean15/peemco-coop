<?php

namespace App\Services\LoanPayment;

use Illuminate\Support\Carbon;


class   LoanPaymentService{




    public $loan;
    public $loanItems;
    public function __construct($loan){

        $this->loan=$loan;
        $this->loanItems =$loan->items;
    }



    public function handle(){

        if($this->loan->status !='approved') return ;


        $tempItem = null;
        $currentDate = Carbon::now();
        $this->loanItems->each(function($item)use (&$tempItem,$currentDate){

            $dueDate = Carbon::parse($item->due_date);


            if($dueDate->lte($currentDate) ){


                $item->update(['status'=>'to pay']);
                if($tempItem ){

                    //if no payment
                    $tempItem->update(['status'=>'overdue']);

                }

            }
            $tempItem = $item;
            //






        });

    }
}
