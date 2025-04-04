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
});

// ProfileController
Route::middleware('auth')->name('profile.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('index');
});
