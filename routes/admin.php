<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;




Route::prefix('/')->group(function(){

    Volt::route('/dashboard','admin.dashboard')->name('admin.dashboard');

    Route::prefix('users')->group(function(){
        Volt::route('/','admin.users')->name('admin.users');
        Volt::route('/add-users','admin.add-users')->name('add-users');
        Volt::route('/{user}','admin.user.profile')->name('admin.user');


    });

    Route::prefix('loan-type')->group(function(){
        Volt::route('/','admin.loan-type')->name('admin.loan-type');
        Volt::route('/{loanType}','admin.loan-type.loan-type-profile')->name('admin.loan-type-profile');
        Volt::route('/add','admin.loan-type.add-loan-type')->name('admin.add-loan-type');



    });

    Volt::route('/capital-build-up','admin.capital-build-up')->name(name: 'admin.capital-build-up');


    Route::prefix('loan')->group(function(){

        // Volt::route('/pending','admin.loan.pending')->name('admin.pending');
        // Volt::route('/profile/{loan}','admin.loan.profile')->name('admin.loan-profile');

        // Volt::route('/active','admin.loan.active')->name('admin.active');
        // Volt::route('/completed','admin.loan.completed')->name('admin.completed');


    });
    Volt::route('/loan-calculator','admin.loan-calculator')->name('admin.loan-calculator');

    Volt::route('/edit-amortization/{payment_id}','admin.edit-amortization')->name('admin.edit-amortization');


    Route::prefix('settings')->group(function(){
        Volt::route('/settings','admin.settings')->name('admin.settings');

    });




});
