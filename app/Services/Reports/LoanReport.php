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

    public function generate()
    {

    }

    protected function generateMonthlyGraph()
    {
        $data = [];
        $this->graph = Loan::selectRaw('SUM(amount_received) as total, CONCAT(YEAR(date), "-", LPAD(MONTH(date), 2, "0"), "-01") as month_year')
            ->groupBy('month_year')
            ->orderBy('month_year') // Ensure chronological order
            ->take($this->series)
            ->get()
            ->each(function ($item) use (&$data) {
                $data['values'][] = (float) $item->total;
                $data['labels'][] = $item->month_year;
            });

        $data['name'] = 'Capital Buildup (Monthly)';

        return $data;
    }

    public function generateStat()
    {
        return Loan::
            whereYear('date_confirmed', now()->year)
            ->where('status', 'approved') // Adjust status as needed
            ->selectRaw('loan_type, COUNT(*) as count')
            ->groupBy(groups: 'loan_type')
            ->pluck('count', 'loan_type'); // Returns an associative array
    }

}
