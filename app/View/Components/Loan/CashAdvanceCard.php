<?php

namespace App\View\Components\Loan;

use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CashAdvanceCard extends Component
{
    /**
     * Create a new component instance.
     */

    public $disabled;
    public function __construct(public $loanType,public string $renderFrom='admin')
    {


        $now = Carbon::now()->format('m-d'); // Get the current date in 'mm-dd' format
        // $now = '06-11';
        $this->disabled = true; // Default to disabled

        foreach ($loanType->releaseDates as $date) {
            $from = Carbon::createFromFormat('m-d', $date->from);
            $to = Carbon::createFromFormat('m-d', $date->to);

            // Check if the current date falls within the range
            if (Carbon::createFromFormat('m-d', $now)->between($from, $to)) {
                $this->disabled = false; // Enable if within range
                break; // No need to check further
            }
        }


        // dd($now);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.loan.cash-advance-card');
    }
}
