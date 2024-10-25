<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CapitalBuildUp extends Model
{
    protected $table = 'capital_build_up';

    public function scopeSearch(Builder $builder,$search){

        return $builder->where('or_cdv',$search);


    }
}
