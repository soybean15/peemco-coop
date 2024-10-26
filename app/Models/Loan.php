<?php

namespace App\Models;

use App\Enums\LoanStatuEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class Loan extends Model
{
    //

    protected $guarded=[];


    public function user(){
        return $this->belongsTo(User::class);
    }


    public function items(){
        return $this->hasMany(LoanItem::class);
    }
    public function scopeSearch(Builder $builder,$search){
        if(empty($search))
        return $builder;

        $builder->where('loan_application_no',$search);


    }

    //fromMember if role member
    public function scopeRetrieve(Builder $builder, $renderFrom){


        // dd(Auth::id());
        $query =  match($renderFrom) {
            LoanStatuEnum::PENDING->value => $builder->pending(),
            LoanStatuEnum::ACTIVE->value=>$builder->active(),
            LoanStatuEnum::COMPLETED->value => $builder->completed(),
            default => $builder->where('user_id',Auth::id()),
        };


        return $query;


    }

    public function scopePending(Builder $builder){
        return $builder->where('status','pending');
    }
    public function scopeActive(Builder $builder){
        return $builder->where('status','approved');
    }
    public function scopeCompleted(Builder $builder){
        return $builder->where('status','completed');
    }
}
