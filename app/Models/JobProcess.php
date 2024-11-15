<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobProcess extends Model
{
    //
    protected $guarded=[];

    public function jobProcessable(){
        return $this->morphTo();
    }

    public function percentage()
    {
        // Check if total_rows is greater than 0 to prevent division by zero
        if ($this->total_rows > 0) {
            return ($this->processed_rows / $this->total_rows) * 100;
        }

        // If total_rows is 0 or not set, return 0% progress
        return 0;
    }

}

