<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\BusinessContractController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:Super Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/contracts', [BusinessContractController::class, 'index'])
            ->middleware('permission:view contracts')
            ->name('contracts.index');
        Route::get('/businesses/{id}/export-pdf', [BusinessExportController::class, 'export'])
            ->middleware(['auth', 'can:export-contracts'])
            ->name('business.export.pdf');
    });
