<?php

namespace App\Services\LoanPayment;

use Illuminate\Support\Carbon;


class   LoanPaymentService
{




    public $loan;
    public $loanItems;
    public function __construct($loan)
    {

        $this->loan = $loan;
        $this->loanItems = $loan->items;
    }



    public function handle()
    {

        if ($this->loan->status != 'approved') return;


        $tempItem = null;

        $this->loanItems->each(function ($item)  {



            (new LoanPaymenItem($item))->handle();
            // $dueDate = Carbon::parse($item->due_date);

            // if ($item->running_balance == 0) {
            //     $item->update(['status' => 'paid']);
            //     $tempItem = $item;
            //     return;
            // }

            // if ($dueDate->lte($currentDate)) {


            //     $item->update(['status' => 'to pay']);

            //     if ($tempItem) {

            //         $tempItem->update(['status' => 'overdue']);



            //     }
            // }

            // if ($tempItem && $tempItem->status == 'paid') {

            //     $item->update(['status' => 'to pay']);
            // }

            // $tempItem = $item;
            // //




        });
    }
}
