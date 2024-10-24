<?php

namespace App\Contracts;

use App\Models\Loan;

interface HasLoan{


    public function handle($data):Loan;
}
