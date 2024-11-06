<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPayment extends Model
{

    protected $fillable=
    [
        'or_cdv',
        'amount_paid',
        'date',
        'loan_id',
        'loan_item_id',
        'added_by'
    ];
}
