<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
                  ->orWhere('type', 'flexible')
                 ;
        }) ->whereNotNull('completed_at');
    }


    public function scopeCashAdvance(Builder $builder)
    {

            $builder->where('type', 'cash_advance')->whereNotNull('completed_at');


    }


    public function loanTypeUsers(){
        return $this->hasMany(LoanTypeUser::class,);
    }


    public function chargeAmount():Attribute{
        return Attribute::make(
            get:function(){


                return $this->minimum_amount *( $this->charges/100);

            }
        );
    }
}
