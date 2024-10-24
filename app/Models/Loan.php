<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\WithPagination;

class Loan extends Model
{
    //

    protected $guarded=[];

    public function scopeSearch(Builder $builder,$search){
        if(empty($search))
        return $builder;

        $builder->where('loan_application_no',$search);


    }
}
