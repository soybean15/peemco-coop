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


        // dd([
        //     'monthly' => $this->monthly_rate,
        //     'annual' => $this->annual_rate,
        //     'principal' => $this->principal,
        //     'number_of_installment' => $this->number_of_installment,
        //     'part1' => $numerator,
        //     'part2' => $denominator,

        //     '$this->monthly_rate' => $this->monthly_rate,
        //     'result' => ($numerator / $denominator),
        //     'monthly_payment' => $this->monthly_payment
        // ]);

        $i=1;
        $initial_interest = $this->principal * $this->monthly_rate;
        $balance = $this->principal-($this->monthly_payment-$initial_interest);

        while($i<=$this->number_of_installment){




            $loanItem = new LoanItem($this, $balance, $i);
            $this->loanItems[]=$loanItem;
            $balance =$loanItem->getBalance();
            $i++;
        }

        dd($this->loanItems);
        // dd($this->principal,$this->number_of_installment,$this->monthly_payment);//50000 ,12

        // dd($this->monthly_payment);//this is 0 why?

    }

    public function getLoanItems()
    {
        return $this->loanItems;
    }
}
