<?php

namespace App\Services\LoanPayment;

use App\Enums\LoanItemStatusEnum;
use App\Models\LoanItem;

class  LoanPaymentService
{
    public $loan;
    public $loanType;
    public function __construct($loan)
    {
        // dd('jer');
        $this->loan = $loan;
        $this->loanType=$loan->loanType;
    }
    // public function processRegularLoan(){

    //     if ($this->loan->status != 'approved') return;

    //     $loanItems = $this->loan->items;
    //     $loanItems->each(function ($item)  {

    //         (new LoanPaymenItem($item))->handle();

    //     });

    // }
    public function processRegularLoan()
    {
        if ($this->loan->status != 'approved') return;

        $loanItems = $this->loan->items;

        // Get the last item


        // Check if the last item is overdue

        // Process the loan items
        $loanItems->each(function ($item) {
            (new LoanPaymenItem($item))->handle();
        });
        $lastItem = $loanItems->last();
        if ($lastItem && $lastItem->status== LoanItemStatusEnum::OVERDUE->value) {
            // Set status to LoanItemStatusEnum::TO_PAY if overdue
            $lastItem->status = LoanItemStatusEnum::TO_PAY->value;
            $lastItem->save();
        }

    }


    public function processCashAdvance(){
        $items = $this->loan->cashAdvanceItems;

        $items->each(function ($item){

            (new CashAdvanceItem($item))->handle();
        });
    }

    public function handle()
    {


        switch($this->loanType->type){
            case 'flexible':
            case 'regular':
                return $this->processRegularLoan();
            case 'cash_advance':
                return $this->processCashAdvance();
            default: return null;

        }

    }
}
