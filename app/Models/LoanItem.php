<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LoanItem extends Model
{
    //
    protected $guarded=[];




    public function payment(){
        return $this->hasMany(LoanPayment::class);
    }
}
