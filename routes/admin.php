<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;




Route::prefix('/')->group(function(){

    Volt::route('/dashboard','admin.dashboard')->name('admin.dashboard');
    Volt::route('/users','admin.users')->name('admin.users');

    Volt::route('/capital-build-up','admin.capital-build-up')->name('admin.capital-build-up');
    Volt::route('/loans','admin.loans')->name('admin.loans');
    Volt::route('/loan-calculator','admin.loan-calculator')->name('admin.loan-calculator');



    
});