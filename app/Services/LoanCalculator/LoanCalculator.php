<?php

namespace App\Services\LoanCalculator;

use App\Models\LoanType;
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

    public $loanType;

    public $charges;

    protected $loanItems = [];


    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getLoanTypes(){
        return LoanType::regular()->get()->map(function($item){
            return [
                'id'=>$item->id,
                'name'=>$item->loan_type
            ];
        });
    }

    public function setUser($user){
        $this->user =$user;
        return $this;
    }
    public function setLoanType($loanTypeId){


        $this->loanType =LoanType::find($loanTypeId);



        return $this;
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

        $this->setLoanDetails();
        return $this;
    }

    public function setLoanDetails(){


        if(!$this->loanType) return 0;

        $rate =$this->loanType->annual_rate/100;

        if ((int)$this->terms === 1) {
            $this->annual_rate = $rate;
        } elseif ((int)$this->terms === 2) {
            $this->annual_rate = $rate * 1.20;
        } elseif ((int)$this->terms > 2) {
            $this->annual_rate = $rate * 1.20 * 1.074;

        } else {
            $this->annual_rate = $rate;
        }
        $this->monthly_rate = $this->annual_rate / 12;;

    }

    public function calculateLoan()
    {

        // dd($this->number_of_installment);

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


    public function getLoanItems($callback=null)
    {

        $i=1;
        $balance = $this->principal;

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
                'balance'=>$loanItem->getOutstandingBalance()
            ];

            if($callback){
                $callback($loanItem);
            }
            $balance =$loanItem->getBalance();
            $i++;
        }
        // dd($this->loanItems);
        return $this->loanItems;
    }

    public function getAnnualRate(){

        return $this->annual_rate;
        // $percentage = number_format($this->annual_rate * 100, 2);
        // return "$percentage%";
    }

    public function getMonthlyRate()
    {

        return $this->monthly_rate;
        // $percentage = number_format($this->monthly_rate * 100, 2);
        // return "$percentage%";
    }

    public function getMonthlyPayment(){
        return $this->monthly_payment;
    }
    public function getNumberOfInstallment(){
        return $this->number_of_installment;
    }
}
