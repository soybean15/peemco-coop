<?php

namespace App\Services\Loans;

use App\Contracts\HasLoan;
use App\Mail\TestEmailNotification;
use Illuminate\Support\Facades\Mail;

class LoanService{

    public HasLoan $loanHandler;

    public function __construct(HasLoan $handler){
        $this->loanHandler = $handler;
    }


    public function handle($data){

        $this->loanHandler->handle($data);

        //EMail

        //adding autdit


    }


}
