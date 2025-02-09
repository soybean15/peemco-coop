<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PdfGenerator;
use App\Http\Controllers\Controller;
use App\Models\Loan;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //

    public function generateLoanApplication(Loan $loan){


        return (new PdfGenerator('invoices.salary-loan-application',['loan'=>$loan]))->stream();


    }

    public function generateLoanReport(Loan $loan){

        // dd($loan);

        return (new PdfGenerator('invoices.loan-report',['loan'=>$loan]))->stream();


    }
}
