<?php

namespace App\Helpers;

use Brick\Math\Exception\NumberFormatException;

class NumberHelper{



    public static function parse($value, $precision=2){

        try{
            
            return round( $value,$precision);

        }catch(NumberFormatException $e){
            return 0;
        }

    }
}
