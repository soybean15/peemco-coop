<?php

namespace App\Services\Reports\Analytics;

use App\Models\Loan;
use Carbon\Carbon;

class TotalAmountIssued
{
    public $frequency;

    public $totalPeriod=12;
    public function __construct($frequency = 'monthly')
    {
        $this->frequency = $frequency;
    }

    protected function generateQuery()
    {
        return Loan::whereNotNull('date_confirmed');
    }

    public function generateReport()
    {
        $query = $this->generateQuery();
        $data = [];

        switch ($this->frequency) {
            case 'yearly':
                $data = $this->mapYearlyData($query);
                break;

            case 'monthly':
                $data = $this->mapMonthlyData($query);
                break;

            case 'weekly':
                $data = $this->mapWeeklyData($query);
                break;
        }

        return ['data' => $data];
    }

    /**
     * Map yearly data.
     */
    protected function mapYearlyData($query)
    {
        $data = [];
        for ($i = 0; $i < $this->totalPeriod; $i++) {
            $date = Carbon::now()->subYears($i);
            $timestamp = $date->timestamp * 1000; // Convert to milliseconds

            $sum = (clone $query)
                ->whereYear('date_confirmed', $date->year)
                ->sum('principal_amount');

            $data[] = [$timestamp, $sum];
        }
        return $data;
    }

    /**
     * Map monthly data.
     */
    protected function mapMonthlyData($query)
    {
        $data = [];
        for ($i = 0; $i < $this->totalPeriod; $i++) {
            $date = Carbon::now()->subMonths($i);
            $timestamp = $date->timestamp * 1000; // Convert to milliseconds

            $sum = (clone $query)
                ->whereYear('date_confirmed', $date->year)
                ->whereMonth('date_confirmed', $date->month)
                ->sum('principal_amount');

            $data[] = [$timestamp, $sum];
        }
        return $data;
    }

    /**
     * Map weekly data.
     */
    protected function mapWeeklyData($query)
    {
        $data = [];
        for ($i = 0; $i < $this->totalPeriod; $i++) {
            $date = Carbon::now()->subWeeks($i)->startOfWeek();
            $timestamp = $date->timestamp * 1000; // Convert to milliseconds

            $sum = (clone $query)
                ->whereBetween('date_confirmed', [$date, $date->copy()->endOfWeek()])
                ->sum('principal_amount');

            $data[] = [$timestamp, $sum];
        }
        return $data;
    }

}
