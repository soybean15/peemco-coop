<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashAdvanceItem extends Model
{
    //
    protected $guarded=[];


    public function loan(){
        return $this->belongsTo(Loan::class);
    }

    public function penalties(){
        return $this->morphMany(LoanPenalty::class,'penaltyable');
    }

}
