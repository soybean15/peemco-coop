<?php

namespace App\Actions\Loan;

use App\Contracts\HasLoan;

use App\Models\Loan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class LoanApproval implements HasLoan

{




    public function handle($data): Loan
    {

        $loan = $data['loan'];
        $loan->update(
            [
                'status'=>'approved',
                'confirmed_by'=>Auth::id(),
                'date_confirmed'=>Carbon::today()
        ]);


        //create Loan Items
        return $loan;
    }

}
