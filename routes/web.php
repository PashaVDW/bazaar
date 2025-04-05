<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Models\Component;
use Illuminate\Http\Request;

Route::get('/', [HomeController::class, 'index'])->name('home');

// HomeController
Route::middleware('auth')->group(function () {
    Route::post('/ads/{ad}/favorite', [HomeController::class, 'favorite'])->name('ads.favorite');
    Route::delete('/ads/{ad}/unfavorite', [HomeController::class, 'unfavorite'])->name('ads.unfavorite');
});

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
    Route::get('/profile/purchases/{timestamp}', [ProfileController::class, 'showPurchase'])->name('purchases.show');
    Route::get('/purchaseHistory', [ProfileController::class, 'purchaseHistory'])->name('purchaseHistory');
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


Route::middleware(['auth', 'role:business_advertiser'])->group(function () {
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing.index');
    Route::get('/landing-page/create', [LandingPageController::class, 'create'])->name('landing.create');
    Route::post('/landing-page/create', [LandingPageController::class, 'store'])->name('landing.store');
    Route::get('/landing-page/edit', [LandingPageController::class, 'edit'])->name('landing.edit');
    Route::post('/landing-page/update', [LandingPageController::class, 'update'])->name('landing.update');
});

Route::post('/component-preview/multi', function (Request $request) {
    $orderedIds = collect($request->input('components', []));
    $components = \App\Models\Component::whereIn('id', $orderedIds)->get()->sortBy(function ($c) use ($orderedIds) {
        return $orderedIds->search($c->id);
    });

    $settings = $request->input('component_settings', []);
    $logo = $settings['global']['logo_base64'] ?? Auth::user()?->business?->landingPage?->logo_path;

    return view('components.landing_components.component-preview-multi', [
        'components' => $components,
        'settings' => $settings,
        'ads' => \App\Models\Ad::where('user_id', Auth::id())->take(4)->get(),
        'reviews' => [],
        'business' => Auth::user()?->business,
        'logo' => $logo,
    ]);
})->name('component.preview.multi');

// CartController
Route::post('/cart/add/{ad}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{ad}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{ad}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

// ReviewController
Route::middleware('auth')->group(function () {
    Route::get('/review/create', [\App\Http\Controllers\ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store', [\App\Http\Controllers\ReviewController::class, 'store'])->name('review.store');
});

Route::get('/{slug}', [LandingPageController::class, 'show'])->name('landing.show');
