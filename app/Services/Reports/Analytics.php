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

    public function numberOfLoansIssued(){
        return Loan::
        whereYear('date_confirmed', now()->year)
        ->where('status', 'approved') // Adjust status as needed
        ->selectRaw('loan_type, COUNT(*) as count')
        ->groupBy(groups: 'loan_type')
        ->pluck('count', 'loan_type');
    }

    public function averageLoanAmount(){

    }

    public function deliquencyRate(){

    }

    public function repaymentRate(){

    }

}
