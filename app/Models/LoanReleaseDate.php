<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class LoanReleaseDate extends Model
{
    //

    protected $guarded = [];


    public function toString(): Attribute
    {
        return Attribute::make(
            get: function () {
                $fromDate = \Carbon\Carbon::createFromFormat('m-d', $this->from)->format('F j');
                $toDate = \Carbon\Carbon::createFromFormat('m-d', $this->to)->format('F j');

                return "{$fromDate} to {$toDate}";
            }
        );
    }
}
