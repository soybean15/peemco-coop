<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapitalBuildUp extends Model
{
    // protected $table = 'capital_build_up';
    use SoftDeletes;
    protected $guarded=[];
    public function scopeSearch(Builder $builder,$search){

        if(empty($search)) return $builder;
        return $builder->where('or_cdv',$search);


    }

    public function addedBy(){
        return $this->belongsTo(User::class,'added_by');
    }
}
