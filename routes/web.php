<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


Route::get('/', [HomeController::class, 'index'])->name('home');

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


// AdvertisementController
Route::middleware(['permission:create advertisements'])->name('advertisements.')->prefix('advertisements')->group(function () {
    Route::get('/', [AdvertiserController::class, 'index'])->name('index');
    Route::get('/create', [AdvertiserController::class, 'create'])->name('create');
    Route::post('/', [AdvertiserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdvertiserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdvertiserController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdvertiserController::class, 'destroy'])->name('destroy');
});
