<?php


use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


//member


Route::prefix('/')->group(function(){


    Volt::route('/home','user.dashboard')->name('user.dashboard');

    Route::prefix('loan')->group(function(){
        Volt::route('/','user.loans')->name('user.loans');
        Volt::route('/profile/{loan}','user.loan.profile')->name('user.loan-profile');

    });

    Volt::route('/profile','user.profile')->name('user.profile');
    Volt::route('/loan-calculator','user.loan-calculator')->name('user.loan-calculator');
    Volt::route('/capital-build-up','user.capital-build-up')->name('user.capital-build-up');


});

