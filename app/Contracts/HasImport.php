<?php

namespace App\Contracts;

use App\Models\Loan;

interface HasImport{


    public function store($data,$jobProcess=null);
}
