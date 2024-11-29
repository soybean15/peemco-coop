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
    public function scopeFlexible(Builder $builder){
        $builder->where('type','flexible');
    }
    public function scopeRegularOrFlexible(Builder $builder)
    {
        $builder->where(function ($query) {
            $query->where('type', 'regular')
                  ->orWhere('type', 'flexible');
        });
    }


    public function scopeCashAdvance(Builder $builder)
    {

            $builder->where('type', 'cash_advance');


    }


    public function loanTypeUsers(){
        return $this->hasMany(LoanTypeUser::class,);
    }
}
