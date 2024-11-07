<?php

namespace App\Services\LoanPayment;

use App\Models\LoanItemPenalty;
use Exception;
use Illuminate\Support\Carbon;

class ComputePenalty{



    public $loanItem;
    public $loan;

    public $loanType;

    public $dueDate;
    public $currentDate;


    public $rate;
    public $grace_period;

    public function __construct($loanItem){

        $this->loanItem = $loanItem;
        $this->loan =$loanItem->loan;
        $this->loanType =$this->loan->loanType;
        $this->dueDate = Carbon::parse($this->loanItem->due_date);
        $this->currentDate = Carbon::now();
        $this->rate =$this->loanType->penalty;
        $this->grace_period = $this->loanType->grace_period;

    }



    public function compute(){



        if($this->loanItem->status =='overdue'){


            if($this->currentDate->gt($this->dueDate)){


                $dayDifference = $this->dueDate->diffInDays($this->currentDate);
                // dd($this->dueDate->format('Y-m-d'),$this->currentDate->format('Y-m-d'),$dayDifference);
                if($dayDifference <= $this->grace_period){
                    return 0;
                }
                // dd('here');

                $penalty = $this->loanItem->running_balance * ($this->rate / 100);
                LoanItemPenalty::updateOrCreate([
                    'loan_item_id'=>$this->loanItem->id,
                ],[

                    'amount' =>$penalty,

                    'rate'=>$this->rate
                ]);
                return $penalty;

            }

        }

        return 0;




    }
}
