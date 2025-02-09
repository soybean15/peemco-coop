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



    public function computePenalty($runningBalance)
    {
        // Return 0 if the due date is greater than or equal to the current date
        if ($this->dueDate->gte($this->currentDate)) {
            return 0;
        }

        $totalPenalty = 0;
        $isCompound = $this->loanType->is_compound_penalty == 1;
        $dueDate = $this->dueDate->copy()->addDays((int) $this->grace_period);

        // Loop until the due date is within the term and overdue
        while ($dueDate->lt($this->endOfTerm) && $dueDate->lte($this->currentDate)) {
            // Skip if a penalty already exists for this date
            if ($this->loanItem->penalties()->where('penalty_date', $dueDate->format('Y-m-d'))->exists()) {
                $dueDate->addDays((int) $this->grace_period);
                continue;
            }

            // Add existing penalties to the running balance for compound penalties
            if ($isCompound) {
                $runningBalance += $totalPenalty;
            }

            // Calculate the penalty
            $penalty = $runningBalance * ($this->rate / 100);
            $totalPenalty += $penalty;

            // Record the penalty
            $this->loanItem->penalties()->create([
                'penalty_date' => $dueDate->format('Y-m-d'),
                'amount' => $penalty,
                'rate' => $this->rate,
                'running_balance' => $totalPenalty + $runningBalance,
            ]);

            // Move to the next grace period
            $dueDate->addDays((int) $this->grace_period);
        }
        $totalPenalties = $this->loanItem->penalties()
       ->whereNull('status')
        ->sum('amount');
    
            return round($totalPenalties, 2);
    
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
