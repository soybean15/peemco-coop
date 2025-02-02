<?php

use App\Http\Controllers\Admin\PdfController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::prefix('/')->group(function(){

    Volt::route('/dashboard','admin.dashboard')->name('admin.dashboard');

    Route::prefix('users')->group(function(){
        Volt::route('/','admin.users')->name('admin.users');
        Volt::route('/archives','admin.user.archive')->name( 'admin.user-archives');

        Volt::route('/add-users','admin.add-users')->name('admin.add-users');
        Volt::route('/add-users', 'admin.add-users')->name('admin.add-users');

        Volt::route('/{user}','admin.user.profile')->name('admin.user');
    });

    Route::prefix('loan-type')->group(function(){
        Volt::route('/','admin.loan-type')->name('admin.loan-type');
        Volt::route('/add','admin.loan-type.add-loan-type')->name('admin.add-loan-type');
        Volt::route('/{loanType}','admin.loan-type.loan-type-profile')->name('admin.loan-type-profile');
    });

    Volt::route('/capital-build-up','admin.capital-build-up')->name('admin.capital-build-up');

    Route::prefix('loan')->group(function(){

        Volt::route('/pending','admin.loan.pending')->name('admin.pending');
        Volt::route('profile/{loan}','admin.loan.profile')->name('admin.loan-profile');
        Volt::route('/active','admin.loan.active')->name('admin.active');
        Volt::route('/completed','admin.loan.completed')->name(name: 'admin.completed');

        Route::get('/loan-application-pdf',[PdfController::class,'generateLoanApplication'])->name( 'admin.generate-loan-application-pdf');



        Route::prefix('apply-loan')->group(function(){
            Volt::route('/','admin.loan-application')->name('admin.loan-application');
            Volt::route('/regular-loan','admin.loan.loan-application')->name(name: 'admin.loan-regular');
            Volt::route('/cash-advance','admin.loan.cash-advance-list')->name('admin.loan-cash-advance');


            Volt::route('/cash-advance/{cashAdvance}','admin.loan.cash-advance-application')->name('admin.loan-cash-advance-list');
        });



        // Volt::route('/completed','admin.loan.completed')->name('admin.completed');
    });

    Volt::route('/edit-amortization/{payment_id}','admin.edit-amortization')->name('admin.edit-amortization');



    Route::prefix('imports')->group(function(){

        Volt::route('/user','admin.imports.user-import')->name('admin.user-import');
        Volt::route('/cbu','admin.imports.cbu-import')->name('admin.cbu-import');





    });

    Route::prefix('settings')->group(function(){
        Volt::route('/','admin.settings')->name('admin.settings');

    });

    Route::prefix('reports')->group(callback: function(){
        Volt::route('/cbu',componentName: 'admin.reports.cbu-reports')->name(name: 'admin.cbu-reports');
        Volt::route('/loan',componentName: 'admin.reports.loan-report')->name('admin.loan-reports');


    });


});
