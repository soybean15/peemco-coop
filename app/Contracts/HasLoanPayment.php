<?php

namespace App\Contracts;

use App\Models\Loan;
use App\Models\LoanPayment;

interface HasLoanPayment{


    public function handle($data):LoanPayment;
}
