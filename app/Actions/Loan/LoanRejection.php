<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;

use App\Models\Loan;

class LoanRejection implements HasLoan

{




    public function handle($data): Loan
    {


        $loan = $data['loan'];
        $loan->update(['status'=>'rejected']);


        return $loan;
    }

}
