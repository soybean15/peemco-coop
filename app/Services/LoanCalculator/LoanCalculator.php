<?php

namespace App\Services\LoanCalculator;

use App\Models\User;

class LoanCalculator{


    protected $user;
    protected $terms;

    protected $number_of_installment;
    protected $principal;
    public $monthly_rate;
    public $annual_rate;//Monthly x terms

    public $nominal_rate;

    public $otherChargesInterest = 0.06;

    protected $loanItems=[];


    public function __construct( $user){

        $this->user =$user;
    }

    public function setPrincipal($principal){
        $this->principal = $principal;
        return $this;

    }

    public function setTerms($terms){
        $this->terms =$terms;

        $this->number_of_installment =$terms * 12;

        return $this;
    }

    public function calculateLoan(){

        $this->principal;






    }

    public function getLoanItems(){
        return $this->loanItems;
    }
}
