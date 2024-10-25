<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;

use App\Models\Loan;

class LoanApproval implements HasLoan

{




    public function handle($data): Loan
    {

        $loan = $data['loan'];
        $loan->update(['status'=>'approved']);


        //create Loan Items
        return $loan;
    }

}
