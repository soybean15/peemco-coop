<?php

namespace App\Services\LoanCalculator;

use App\Helpers\NumberHelper;

class  LoanItem {


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

        $this->net_proceed= $this->monthly_payment;


        $this->compute();
    }

    public function compute(){
        // dd($this->balance,$this->monthly_rate);
        $this->interest =   NumberHelper::parse($this->balance * $this->monthly_rate) ;
        $this->principal =NumberHelper::parse($this->monthly_payment-$this->interest);
    }

    public function getBalance(){

        $this->outstanding_balance =  $this->balance-$this->principal;
    //    debugbar()->info($this->outstanding_balance);
        return
        $this->outstanding_balance ;
    }


    public function getPeriod()
    {
        return $this->period;
    }

    public function getGross()
    {
        return $this->gross;
    }

    public function getPrincipal()
    {
        return $this->principal;
    }

    public function getInterest()
    {
        return $this->interest;
    }

    public function getNetProceed()
    {
        return $this->net_proceed;
    }

    public function getOutstandingBalance()
    {
        return $this->balance - $this->principal;
    }

    public function getMonthlyPayment()
    {
        return $this->monthly_payment;
    }

    public function getMonthlyRate()
    {
        return $this->monthly_rate;
    }



    public function save(){

    }
}
