<?php

use App\Http\Controllers\AnalyticsController;
use Illuminate\Support\Facades\Route;


Route::prefix('analytics')->name('analytics.')->group(function () {
    Route::get('/total-loan', [AnalyticsController::class, 'getTotalAmountIssued'])->name('total-loan');
    Route::get('/top-contributor', [AnalyticsController::class, 'getTopContributor'])->name('top-contributors');
    Route::get('/loan-issued', [AnalyticsController::class, 'getLoanIssued'])->name('loan-issued');

});
