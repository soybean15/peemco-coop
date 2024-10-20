<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;




Route::prefix('/')->group(function(){

    Volt::route('/dashboard','admin.dashboard')->name('admin.dashboard');
    Volt::route('/loan','admin.users')->name('admin.users');

    Volt::route('/loan','admin.capital-build-up')->name('admin.capital-build-up');
    Volt::route('/loan','admin.loans')->name('admin.loans');
    Volt::route('/loan','admin.loan-calculator')->name('admin.loan-calculator');



    
});