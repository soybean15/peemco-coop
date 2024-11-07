<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanItemPenalty extends Model
{
    //
    protected $fillable =
    [
        'loan_item_id',
        'amount',
        'rate'
    ];
}
