<?php

namespace App\Services\LoanPayment;


class ComputePenalty{



    public $loanItem;

    public function __construct($loanItem){

        $this->loanItem = $loanItem;
    }

    public function getPenalty(){


    }
}
