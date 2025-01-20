<?php

namespace App\Services\LoanPayment;

use App\Enums\LoanItemStatusEnum;
use App\Models\CashAdvanceItem as ModelsCashAdvanceItem;
use Illuminate\Support\Carbon;

class CashAdvanceItem
{


    public $item;

    public $currentDate;

    public $dueDate;
    public $loanType;

    public function __construct(ModelsCashAdvanceItem $item){
        // dd($item);
        $this->item=$item;
        $this->loanType = $item->loan->loanType;
        $this->currentDate = Carbon::now();
        $this->dueDate = Carbon::parse($item->due_date);
    }


    public function handle(){

       $this->item->status =  $this->setStatus();
       $penalty = (new ComputePenalty($this->item))->compute();

    //    dd($penalty);
       $this->item->penalty = $penalty;
       $this->item->save();
    //    dd($penalty);
    //    dd($this->item->status);
    // dd('jer');

    }

    public function setStatus(){

        $gracePeriod = $this->loanType->grace_period;

        $date = $this->dueDate->copy()->addDays((int)$gracePeriod);

        if($this->currentDate->lte($date)) return LoanItemStatusEnum::PENDING->value;

        $payment = $this->item->payments->first();

        if ($payment && $payment->amount_paid >= $this->item->charge_amount) {

            return LoanItemStatusEnum::PAID->value;
        }

        return LoanItemStatusEnum::OVERDUE->value;

        // dd($date->format('Y-m-d'));


    }


    public function compute(){

        $gracePeriod = $this->loanType->grace_period;
        $date = $this->dueDate->copy()->addDays((int)$gracePeriod);
        while($this->currentDate->gt($date)){

        }

    }
}
