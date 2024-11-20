<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\PdfGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    //

    public function generateLoanApplication(){


        return (new PdfGenerator('invoices.salary-loan-application'))->stream();


    }
}
