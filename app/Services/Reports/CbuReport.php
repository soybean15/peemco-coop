<?php

namespace App\Services\Reports;

use App\Models\CapitalBuildUp;

class CbuReport
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

    public function generateReports($year = null)
    {
        if (is_null($year)) {
            $year = date('Y'); // Get current year
        }


        $this->reports = CapitalBuildUp::whereYear('date', $year)
           ;

        return $this->reports;
    }

    public function generateGraph()
    {
        switch ($this->mode) {
            case 'monthly':
                return $this->generateMonthlyGraph();
            case 'yearly':
                return $this->generateYearlyGraph();
            default:
                return []; // Return empty array or a default response
        }
    }

    protected function generateMonthlyGraph()
    {
        $data = [];
        $this->graph = CapitalBuildUp::selectRaw('SUM(amount_received) as total, CONCAT(YEAR(date), "-", LPAD(MONTH(date), 2, "0"), "-01") as month_year')
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

    protected function generateYearlyGraph()
    {
        $data = [];
        $this->graph = CapitalBuildUp::selectRaw('SUM(amount_received) as total, YEAR(date) as year')
            ->groupBy('year')
            ->orderBy('year', 'asc') // Ensure ascending order
            ->get() // Fetch all results first
            ->take($this->series) // Apply limit after sorting
            ->each(function ($item) use (&$data) {
                $data['values'][] = (float) $item->total;
                $data['labels'][] = (string) $item->year;
            });
    
        $data['name'] = 'Capital Buildup (Yearly)';
    
   
        return $data;
    }
    
}
