<?php

namespace App\Services\Loans;

use App\Contracts\HasLoan;

class LoanService{

    public HasLoan $loanHandler;

    public function __construct(HasLoan $handler){
        $this->loanHandler = $handler;
    }


    public function handle($data){
        // dd($data);
        $this->loanHandler->handle($data);
    }
}
