<?php

namespace App\Services\LoanCalculator;

use App\Models\User;

class LoanCalculator
{


    protected $user;
    public  $terms;

    public $number_of_installment;
    public $principal;
    public $monthly_rate;
    public $annual_rate; //Monthly x terms

    public $monthly_payment;

    public $nominal_rate;

    public $otherChargesInterest = 0.06;

    protected $loanItems = [];


    public function __construct($user)
    {

        $this->user = $user;
    }

    public function setPrincipal($principal)
    {
        $this->principal = $principal;
        return $this;
    }

    public function setTerms($terms)
    {
        $this->terms = $terms;

        $this->number_of_installment = $terms * 12;


        return $this;
    }

    public function calculateLoan()
    {

        $this->annual_rate = 0.0750;
        $this->monthly_rate = $this->annual_rate / 12;;

        // Step 1: Calculate the numerator
        $numerator = $this->monthly_rate * pow(1 + $this->monthly_rate, $this->number_of_installment);

        // Step 2: Calculate the denominator
        $denominator = pow(1 + $this->monthly_rate, $this->number_of_installment) - 1;

        // Step 3: Calculate the monthly payment using the amortization formula
        $this->monthly_payment = round($this->principal * ($numerator / $denominator), 2);



        //separate function

        // dd($this->loanItems);
        // dd($this->principal,$this->number_of_installment,$this->monthly_payment);//50000 ,12

        // dd($this->monthly_payment);//this is 0 why?

        return $this;

    }

    public function getLoanItems()
    {

        $i=1;
        $initial_interest = $this->principal * $this->monthly_rate;
        $balance = $this->principal-($this->monthly_payment-$initial_interest);

        while($i<=$this->number_of_installment){



            // $this->loanItems[]=[
            //     'period'=>$loanItem->getPeriod(),
            //     'principal'=>$loanItem->getPrincipal(),
            //     'net_proceed'=>$loanItem->getNetProceed(),
            //     'balance'=>$loanItem->getOutstandingBalance()
            // ];
            $loanItem = new LoanItem($this, $balance, $i);
            // $this->loanItems[]=$loanItem;

            $this->loanItems[]=[
                'period'=>$loanItem->getPeriod(),
                'interest'=>$loanItem->getInterest(),
                'principal'=>$loanItem->getPrincipal(),
                'net_proceed'=>$loanItem->getNetProceed(),
                'balance'=>$balance
            ];
            $balance =$loanItem->getBalance();
            $i++;
        }
        // dd($this->loanItems);
        return $this->loanItems;
    }
}