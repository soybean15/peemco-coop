<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LoanTypeUser extends Model
{
    //
    protected $fillable =['user_id','loan_type_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeSearch(Builder $builder,$search){
        $builder->whereHas('user',function($query) use ($search){
            $query->search($search);
        });
    }



}
