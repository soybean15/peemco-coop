<?php

namespace App\Services\LoanPayment;

use App\Models\LoanItemPenalty;
use Exception;
use Illuminate\Support\Carbon;

class ComputePenalty
{



    public $loanItem;
    public $loan;

    public $loanType;

    public $dueDate;
    public $currentDate;


    public $rate;
    public $grace_period;

    public $endOfTerm;

    public function __construct($loanItem)
    {


        $this->loanItem = $loanItem;
        $this->loan = $loanItem->loan;
        $this->loanType = $this->loan->loanType;
        // dd($this->loanType);
        $this->dueDate = Carbon::parse($this->loanItem->due_date)
        // ->subMonths(2)
        ;
        $this->currentDate = Carbon::now();
        $this->rate = $this->loanType->penalty;
        $this->grace_period = $this->loanType->grace_period;

        $this->endOfTerm = $this->dueDate->copy()->addMonth();
    }


    // public function computeRegularLoanPenalty(){
    //     if($this->dueDate->gte($this->currentDate)){
    //         return 0;
    //     }
    //     $total_penalty=0;
    //     $running_balance =     $this->loanItem->running_balance ;
    //     $is_compound= $this->loanType->is_compound_penalty==1;
    //     $_due = $this->dueDate->copy()->addDays((int)$this->grace_period);


    //     $test=[];
    //     while($_due->lt($this->endOfTerm)){

    //         if($_due->lte($this->currentDate)){

    //             if($is_compound){
    //                 $running_balance+=$total_penalty;
    //             }


    //             $penalty = $running_balance * ($this->rate / 100);
    //             $total_penalty+=$penalty;
    //             // $test[]=$total_penalty;

    //             $this->loanItem->penalties()->updateOrCreate([

    //                 'penalty_date'=>$_due->format('Y-m-d'),
    //             ],[

    //                 'amount' =>$penalty,
    //                 'rate'=>$this->rate,
    //                 'running_balance'=>$total_penalty + $running_balance
    //             ]);

    //             $_due->addDays((int)$this->grace_period);
    //             continue;

    //         }

    //         break;


    //     }
    //     return round($total_penalty,2);

    // }

    // public function computeCashAdvancePenalty(){
    //     if($this->dueDate->gte($this->currentDate)){
    //         return 0;
    //     }
    //     $total_penalty=0;
    //     $running_balance =     $this->loanItem->amount_to_pay ;
    //     $is_compound= $this->loanType->is_compound_penalty==1;
    //     $_due = $this->dueDate->copy()->addDays((int)$this->grace_period);
    //     while($_due->lt($this->endOfTerm)){

    //         if($_due->lte($this->currentDate)){

    //             if($is_compound){
    //                 $running_balance+=$total_penalty;
    //             }


    //             $penalty = $running_balance * ($this->rate / 100);
    //             $total_penalty+=$penalty;
    //             // $test[]=$total_penalty;

    //             $this->loanItem->penalties()->updateOrCreate([

    //                 'penalty_date'=>$_due->format('Y-m-d'),
    //             ],[

    //                 'amount' =>$penalty,
    //                 'rate'=>$this->rate,
    //                 'running_balance'=>$total_penalty + $running_balance
    //             ]);

    //             $_due->addDays((int)$this->grace_period);
    //             continue;

    //         }

    //         break;


    //     }
    //     return round($total_penalty,2);


    // }
    // public function compute(){

    //     return match($this->loanType->type){
    //         'regular'=>$this->computeRegularLoanPenalty(),
    //         'cash_advance'=>$this->computeCashAdvancePenalty(),
    //         default =>$this->computeRegularLoanPenalty()
    //     };


    // }


    public function computePenalty($runningBalance)
    {
        if ($this->dueDate->gte($this->currentDate)) {
            return 0;
        }

        $total_penalty = 0;
        $is_compound = $this->loanType->is_compound_penalty == 1;
        $_due = $this->dueDate->copy()->addDays((int)$this->grace_period);

        // dd($_due->format('Y-m-d'));
        while ($_due->lt($this->endOfTerm)) {
            if ($_due->lte($this->currentDate)) {
                if ($is_compound) {
                    $runningBalance += $total_penalty;
                }

                $penalty = $runningBalance * ($this->rate / 100);
                $total_penalty += $penalty;

                $this->loanItem->penalties()->updateOrCreate([
                    'penalty_date' => $_due->format('Y-m-d'),
                ], [
                    'amount' => $penalty,
                    'rate' => $this->rate,
                    'running_balance' => $total_penalty + $runningBalance,
                ]);

                $_due->addDays((int)$this->grace_period);
                continue;
            }

            break;
        }

        return round($total_penalty, 2);
    }

    public function compute()
    {

        return match ($this->loanType->type) {
            'regular' => $this->computePenalty($this->loanItem->running_balance),
            'cash_advance' => $this->computePenalty($this->loanItem->amount_to_pay),
            default => $this->computePenalty($this->loanItem->running_balance),
        };
    }





    public function _compute()
    {



        if ($this->loanItem->status == 'overdue') {


            if ($this->currentDate->gt($this->dueDate)) {


                $dayDifference = $this->dueDate->diffInDays($this->currentDate);
                // dd($this->dueDate->format('Y-m-d'),$this->currentDate->format('Y-m-d'),$dayDifference);
                if ($dayDifference <= $this->grace_period) {
                    return 0;
                }
                // dd('here');

                $penalty = $this->loanItem->running_balance * ($this->rate / 100);
                LoanItemPenalty::updateOrCreate([
                    'loan_item_id' => $this->loanItem->id,
                ], [

                    'amount' => $penalty,

                    'rate' => $this->rate
                ]);
                return $penalty;
            }
        }

        return 0;
    }
}
