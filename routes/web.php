<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\BusinessContractController;
use App\Models\Business;
use App\Models\User;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['role:Super Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/contracts', [BusinessContractController::class, 'index'])
            ->middleware('permission:view contracts')
            ->name('contracts.index');
        Route::get('/admin/businesses/{id}/export-pdf', [BusinessExportController::class, 'export'])
            ->middleware(['auth', 'can:export-contracts'])
            ->name('business.export.pdf');
    });
