<?php

namespace App\Services\Reports;

use App\Models\CapitalBuildUp;

class CbuReport
{
    public $graph;
    protected $mode;

    public function __construct($mode = 'monthly')
    {
        $this->mode = $mode;
    }

    public function generate($series = 10)
    {
        switch ($this->mode) {
            case 'monthly':
                return $this->generateGraph($series);
            case 'yearly':
                // Your yearly report generation logic here
                break;
            default:
                // Default report generation logic here
                break;
        }
    }


    public function generateGraph($series = 10)
    {

        $data = [];
        $this->graph = CapitalBuildUp::selectRaw('SUM(amount_received) as total, CONCAT(YEAR(date), "-", LPAD(MONTH(date), 2, "0"), "-01") as month_year')
            ->groupBy('month_year')
            ->orderBy('month_year') // Ensure chronological order
            ->take($series)
            ->get()
            ->each(function ($item) use (&$data) {
                $data['values'][] = (float) $item->total;
                $data['labels'][] = $item->month_year;
            });

        $data['name'] = 'Capital Buildup';

        return $data;
    }
}
