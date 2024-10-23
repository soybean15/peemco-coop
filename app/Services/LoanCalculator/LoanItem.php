<?php

namespace App\Services\LoanCalculator;


class  LoanItem{


    protected $period;
    protected $gross;

    protected $principal;
    protected $interest;

    protected $net_proceed;
    protected $outstanding_balance;
    protected $monthly_payment;
    protected $monthly_rate;

    protected $balance;



    public function __construct(LoanCalculator $loanCalculator,$balance,$terms){


        $this->balance =$balance;
        $this->period =$terms;
        $this->monthly_payment = $loanCalculator->monthly_payment;
        $this->monthly_rate = $loanCalculator->monthly_rate;


        $this->compute();
    }

    public function compute(){
        $this->interest = $this->balance * $this->monthly_rate;
        $this->principal = $this->monthly_payment-$this->interest;
    }

    public function getBalance(){
        return $this->balance-$this->principal;
    }

    public function save(){
        
    }
}
