<?php

namespace App\Services\LoanPayment;
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
    public function processRegularLoan(){

        if ($this->loan->status != 'approved') return;

        $loanItems = $this->loan->items;
        $loanItems->each(function ($item)  {

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
