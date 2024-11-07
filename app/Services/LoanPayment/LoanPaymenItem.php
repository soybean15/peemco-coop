<?php

namespace App\Services\LoanPayment;

use App\Enums\LoanItemStatusEnum;
use App\Models\LoanItem;
use Exception;
use Illuminate\Support\Carbon;

class LoanPaymenItem{




    public $loanItem;
    public $currentDate;

    public $dueDate;

    public $loan;
    public function __construct($loanItem){
        $this->currentDate = Carbon::now();
        $this->loanItem =$loanItem;
        $this->loan =$loanItem->loan;

        $this->dueDate =Carbon::parse($loanItem->due_date);

    }


    public function handle(){

        try{
            $this->loanItem->status = $this->setStatus();
            $this->loanItem->past_due = $this->setPastDue();
            $this->loanItem->total_due = $this->setTotalDue();
            $this->loanItem->running_balance = $this->setRunningBalance();
            $this->loanItem->penalty =   (new ComputePenalty($this->loanItem))->compute();

            $this->loanItem->save();
        }catch(Exception $e){


        }



    }




    public function setStatus(){

        if($this->dueDate->gt($this->currentDate)){
            return LoanItemStatusEnum::PENDING->value;
        }

        if($this->dueDate->between($this->currentDate, $this->currentDate->copy()->subMonth())){
            return LoanItemStatusEnum::TO_PAY->value;
        }

        if($this->loanItem->running_balance==0){
            return  LoanItemStatusEnum::PAID->value;
        }

        return LoanItemStatusEnum::OVERDUE->value;

    }

    public function setPastDue(){
        $loanPeriod  = $this->loanItem->loan_period;
        $previousTerm = LoanItem::where('loan_period',$loanPeriod-1)->where('loan_id',$this->loan->id)->first();


        if($previousTerm && $previousTerm->status=='overdue' &&  $loanPeriod>1){


            return( $previousTerm->running_balance  )- $previousTerm->amount_paid;


        }
        return 0;

    }

    public function setTotalDue(){
        return $this->loanItem->amount_due +$this->loanItem->past_due;
    }

    public function setRunningBalance(){
        return(  $this->loanItem->total_due +$this->loanItem->penalty)  - $this->loanItem->amount_paid;
    }
}
