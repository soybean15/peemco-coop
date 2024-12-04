<?php

namespace App\Services\Loans;

use App\Contracts\HasLoanPayment;

class PaymentService{

    public HasLoanPayment $loanHandler;

    public function __construct(HasLoanPayment $handler){
        $this->loanHandler = $handler;
    }


    public function handle($data){

        $this->loanHandler->handle($data);

        //EMail

        //adding autdit


    }


}
