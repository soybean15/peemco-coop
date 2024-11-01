<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanType extends Model
{
    //

    use SoftDeletes;
    protected $guarded = [];


    public function releaseDates(){
        return $this->hasMany(LoanReleaseDate::class);
    }

    public function getReleaseDates(){
        return $this->releaseDates->map(function ($item){

                return [
                    'start'=>$item->from,
                    'end'=>$item->to
                ];
        });
    }

    public function scopeRegular(Builder $builder){
        $builder->where('type','regular');
    }
}
