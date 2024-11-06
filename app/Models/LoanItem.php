<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LoanItem extends Model
{
    //
    protected $guarded=[];




    public function payment(){
        return $this->hasMany(LoanPayment::class);
    }

    public function loan(){
        return $this->belongsTo(Loan::class);
    }
    public function totalAmountDue():Attribute{

        return Attribute::make(
            get:function(){
                return $this->amount_due + $this->past_due;
            }
        );

    }
}
