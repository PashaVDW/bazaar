<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// BusinessExportController
Route::middleware(['auth', 'role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/businesses/{id}/export-pdf', [BusinessExportController::class, 'export'])->name('business.export.pdf');
});

// AdminController
Route::middleware(['auth', 'role:Super Admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/contracts', [AdminController::class, 'contractIndex'])->name('contracts.index');
    Route::get('/contracts/{business}/upload', [AdminController::class, 'uploadContract'])->name('upload');
    Route::post('/contracts/{business}/upload', [AdminController::class, 'saveUploadedContract'])->name('contracts.upload.save');
});

// ProfileController
Route::middleware('auth')->name('profile.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('index');
    Route::post('/profile/contract/upload', [BusinessExportController::class, 'saveUploadedContract'])->name('contract.upload.save');
    Route::get('/profile/contract', [BusinessExportController::class, 'showContract'])->name('contract');
});

