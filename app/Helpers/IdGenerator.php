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
        $timestamp = now()->format('YmdHis');

        // Extract the last $length characters of the timestamp
        $paddedPart = substr($timestamp, -$length);

        return $prefix . $paddedPart;
    }


}
