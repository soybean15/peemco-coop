<?php


use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


//member


Route::prefix('/')->group(function(){


    Volt::route('/home','user.dashboard')->name('user.dashboard');
    Volt::route('/loans','user.loans')->name('user.loans');
    Volt::route('/loan-calculator','user.loan-calculator')->name('user.loan-calculator');


});

