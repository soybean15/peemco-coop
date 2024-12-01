<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanPenalty extends Model
{
    //
    protected $guarded =[];

    public function penaltyable(){
        return $this->morphTo();
    }
}
