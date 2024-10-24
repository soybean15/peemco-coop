<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;
use App\Models\Loan;


class LoanPayment implements HasLoan
{

    public function handle($data): Loan{

        return new Loan();
    }

}
