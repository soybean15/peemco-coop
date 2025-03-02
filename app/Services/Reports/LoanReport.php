<?php

namespace App\Services\Reports;

use App\Models\Loan;

class LoanReport
{



    public $reports;
    public $graph;

    protected $mode;
    protected $series;


    public function __construct($mode = 'monthly', $series = 10)
    {
        $this->mode = $mode;
        $this->series = $series;
    }

    public function generate($year = null)
    {
        if (is_null($year)) {
            $year = now()->year;
        }

        return Loan::whereYear('date_confirmed', $year)
            ->where('status', 'approved');
    }



    public function generateStat($year = null)
    {
        if (is_null($year)) {
            $year = now()->year;
        }

        return Loan::whereYear('date_confirmed', $year)
            ->where('status', 'approved') // Adjust status as needed
            ->selectRaw('loan_type, COUNT(*) as count')
            ->groupBy('loan_type')
            ->pluck('count', 'loan_type'); // Returns an associative array
    }

}
