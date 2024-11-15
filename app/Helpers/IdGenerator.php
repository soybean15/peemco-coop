<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class IdGenerator{



    public static function generateId($prefix, $length)
    {
        $prefix = trim($prefix);

        if (!empty($prefix)) {
            $prefix .= '-';
        }

        $timestamp = now()->format('YmdHis');

        // Generate a random number padded to the required length
        $randomNumber = str_pad(random_int(0, pow(4, $length) - 1), $length, '0', STR_PAD_LEFT);

        // Take only the last $length characters of the random number
        $uniquePart = substr($randomNumber, -$length);

        return $prefix . $uniquePart;
    }


}
