<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class LoanPenalty extends Model
{
    //
    protected $guarded =[];

    public function penaltyable(){
        return $this->morphTo();
    }

    public function penaltyDateString(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Carbon::parse($this->penalty_date)->format('F j, Y');
            }
        );
    }

}
