<?php

namespace App\Services\LoanCalculator;

use App\Models\LoanType;
use App\Models\User;
use App\Services\LoanType\LoanTypeService;
use Carbon\Carbon;
use Exception;

class LoanCalculator
{


    protected $user;
    public  $terms_in_year;

    public $number_of_installment;
    public $principal;
    public $monthly_rate;
    public $annual_rate; //Monthly x terms_in_year

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
        return LoanType::regularOrFlexible()->get()->map(function($item){
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

    public function setTerms($terms_in_years, $terms_in_month)
    {



        $this->terms_in_year = $terms_in_years;


        $this->number_of_installment = ($terms_in_years ? $terms_in_years : 0) * 12;


        $this->number_of_installment +=$terms_in_month;



        $this->setLoanDetails();
        return $this;
    }

    public function setLoanDetails(){



        if(!$this->loanType) return 0;

        $annual_rate =$this->loanType->annual_rate;

        // if($annual_rate==0){
        //      return $this->monthly_rate=1;
        // }
        $rate =$this->loanType->annual_rate/100;

        // dd($rate);
        if ((int)$this->terms_in_year === 1) {
            $this->annual_rate = $rate;
        } elseif ((int)$this->terms_in_year === 2) {
            $this->annual_rate = $rate * 1.20;
        } elseif ((int)$this->terms_in_year > 2) {
            $this->annual_rate = $rate * 1.20 * 1.074;

        } else {
            $this->annual_rate = $rate;
        }
        $this->monthly_rate = $this->annual_rate / 12;;

    }

    public function calculateLoan()
    {


        if($this->loanType->type=='flexible') return $this;


        if($this->number_of_installment > $this->loanType->maximum_period){

            $max =$this->loanType->maximum_period;

            throw new Exception( "Maximum period is  $max months");
        }
        if($this->number_of_installment ==0){

            throw new Exception("Period cannot be zero, please select terms!");
        }


        // // Step 1: Calculate the numerator
        // $numerator = $this->monthly_rate * pow(1 + $this->monthly_rate, $this->number_of_installment);

        // // Step 2: Calculate the denominator
        // $denominator = pow(1 + $this->monthly_rate, $this->number_of_installment) - 1;
        // // dd($this->number_of_installment,$numerator,$denominator,$this->monthly_rate);

        // // Step 3: Calculate the monthly payment using the amortization formula
        // $this->monthly_payment = round($this->principal * ($numerator / $denominator), 2);

        if ($this->monthly_rate == 0) {
            // If the monthly rate is 0, the monthly payment is simply the principal divided by the number of installments
            $this->monthly_payment = round($this->principal / $this->number_of_installment, 2);
        } else {
            // Step 1: Calculate the numerator
            $numerator = $this->monthly_rate * pow(1 + $this->monthly_rate, $this->number_of_installment);

            // Step 2: Calculate the denominator
            $denominator = pow(1 + $this->monthly_rate, $this->number_of_installment) - 1;

            // Step 3: Calculate the monthly payment using the amortization formula
            $this->monthly_payment = round($this->principal * ($numerator / $denominator), 2);
        }


        //separate function

        // dd($this->loanItems);
        // dd($this->principal,$this->number_of_installment,$this->monthly_payment);//50000 ,12

        // dd($this->monthly_payment);//this is 0 why?

        return $this;

    }


    public function getLoanItems($callback=null)
    {


        if($this->loanType->type=='flexible') return;

        $i=1;
        $balance = $this->principal;


        $dueDate = Carbon::now();

        while($i<=$this->number_of_installment){

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
                $callback($loanItem,$dueDate);

                $dueDate->addMonth();
            }
            $balance =$loanItem->getBalance();
            $i++;
        }

        // dd($this->loanItems);
        return $this->loanItems;
    }

    public function getAnnualRate(){

        return $this->annual_rate;

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


    public function getLoanType(){
        return $this->loanType;
    }

    public function getUsers($search){

        return (new LoanTypeService($this->loanType))->getUsers($search);

        //
    }
    public function getCharges(){
        if(!$this->loanType)return 0;
        return $this->loanType->charges;
    }

    public function getChargesAmount()
    {
        if(!$this->loanType)return 0;
        return ($this->loanType->charges / 100) * $this->principal;
    }

}
