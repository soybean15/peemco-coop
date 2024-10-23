<?php

namespace App\Services\LoanCalculator;


class  LoanItem{


    protected $period;
    protected $gross;

    protected $principal;
    protected $interest;

    protected $net_proceed;
    protected $outstanding_balance;


    public function __construct($term, $principal){

        $this->period =$term;
        $this->principal =$principal;


    }
}
