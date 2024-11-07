<?php

namespace App\Services\LoanPayment;

use App\Enums\LoanItemStatusEnum;
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
        $this->loanItem->status = $this->setStatus();
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

    // public function compute
}
