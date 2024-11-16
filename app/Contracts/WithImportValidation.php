<?php

namespace App\Contracts;

use App\Models\Loan;

interface WithImportValidation{


    public function validate();
}
