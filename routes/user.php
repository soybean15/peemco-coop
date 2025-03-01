<?php


use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


//member


Route::prefix('/')->group(function(){


    Volt::route('/home','user.dashboard')->name('user.dashboard')
    ->middleware('is_admin');

    Route::prefix('loan')->group(function(){
        Volt::route('/','user.loans')->name('user.loans');
        Volt::route('/profile/{loan}','user.loan.profile')->name('user.loan-profile');

    });

    Route::prefix('apply-loan')->group(function(){
        Volt::route('/','user.loan-application')->name(name: 'user.loan-application');
        Volt::route('/regular-loan','user.loan.loan-application')->name( 'user.loan-regular');

        Volt::route('/cash-advance','user.loan.cash-advance-list')->name('user.loan-cash-advance');
        Volt::route('/cash-advance/{cashAdvance}','user.loan.cash-advance-application')->name('user.loan-cash-advance-list');
        // Volt::route('/profile/{loan}','user.loan.profile')->name('user.loan-profile');

    });


    Volt::route('/profile','user.profile')->name('user.profile');
    Volt::route('/loan-calculator','user.loan-calculator')->name('user.loan-calculator');
    Volt::route('/capital-build-up','user.capital-build-up')->name('user.capital-build-up');


});

