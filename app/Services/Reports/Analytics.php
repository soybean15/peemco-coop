<?php

namespace App\Services\Reports;

use App\Models\Loan;
use App\Services\Reports\Analytics\TopContributor;
use App\Services\Reports\Analytics\TotalAmountIssued;

class Analytics
{
    public function __construct()
    {

    }

    public function totalAmountIssued($frequency){

        return (new TotalAmountIssued($frequency))->generateReport();
    }

    public function topContributor(){
        return (new TopContributor())->generateReport();

    }

    public function numberOfLoansIssued($year = null)
    {
        $year ??= now()->year; // Use provided year or default to the current year

        return Loan::whereYear('date_confirmed', $year)
            ->where('status', 'approved') // Adjust status as needed
            ->selectRaw('loan_type, COUNT(*) as count')
            ->groupBy('loan_type')
            ->pluck('count', 'loan_type');
    }

    public function averageLoanAmount($year = null)
    {


        return Loan::whereYear('date_confirmed', $year)
            ->where('status', 'approved') // Adjust status as needed
            ->avg('principal_amount'); // Directly get the overall average
    }





    public function deliquencyRate(){

    }

    public function repaymentRate(){

    }

}
