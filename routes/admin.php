<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;




Route::prefix('/')->group(function(){

    Volt::route('/dashboard','admin.dashboard')->name('admin.dashboard');

    Route::prefix('users')->group(function(){
        Volt::route('/','admin.users')->name('admin.users');
        Volt::route('/{user}','admin.user.profile')->name('admin.user');

    });

    Volt::route('/capital-build-up','admin.capital-build-up')->name('admin.capital-build-up');
    Volt::route('/loans','admin.loans')->name('admin.loans');
    Volt::route('/loan-calculator','admin.loan-calculator')->name('admin.loan-calculator');



    
});