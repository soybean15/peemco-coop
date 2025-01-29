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




    public function processRegularLoan()
    {
        $loanItems = $this->loan->items;
        $lastItem = $loanItems->last();

        // dd($lastItem);
        if ($lastItem && $lastItem->status== LoanItemStatusEnum::OVERDUE->value) {
            // Set status to LoanItemStatusEnum::TO_PAY if overdue
            $lastItem->status = LoanItemStatusEnum::TO_PAY->value;
            $lastItem->save();
        }

        if ($lastItem && $lastItem->status== LoanItemStatusEnum::PAID->value) {
            $this->loan->status = 'completed';
            $this->loan->save();
        }
        if ($this->loan->status != 'approved') return;



        $loanItems->each(function ($item) {
            (new LoanPaymenItem($item))->handle();
        });


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
