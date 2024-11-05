<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class IdGenerator{



    public static function generateId($prefix, $length)
    {

        $prefix = trim($prefix);


        if (!empty($prefix)) {
            $prefix = $prefix . '-';
        } else {
            $prefix = '';
        }
        //$timestamp = now()->format('YmdHis');
        $randNumber =  random_int(1, 100000000000);

        // Extract the last $length characters of the timestamp
        //$paddedPart = substr($timestamp, -$length);

        $paddedPart = substr($randNumber, -$length);

        return $prefix . $paddedPart;
    }


}
