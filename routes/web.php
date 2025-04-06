<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\BusinessSettingsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// HomeController
Route::middleware('auth')->group(function () {
    Route::post('/ads/{ad}/favorite', [HomeController::class, 'favorite'])->name('ads.favorite');
    Route::delete('/ads/{ad}/unfavorite', [HomeController::class, 'unfavorite'])->name('ads.unfavorite');
    Route::get('/ads/{ad}', [HomeController::class, 'show'])->name('ads.show');

});

// BusinessExportController & AdminController
Route::middleware(['auth', 'role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/businesses/{id}/export-pdf', [BusinessExportController::class, 'export'])->name('business.export.pdf');
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
    Route::get('/rentalHistory', [ProfileController::class, 'rentalHistory'])->name('rentalHistory');
});

// AdvertiserController
Route::middleware(['permission:create advertisements'])->name('advertisements.')->prefix('advertisements')->group(function () {
    Route::get('/', [AdvertiserController::class, 'index'])->name('index');
    Route::get('/create', [AdvertiserController::class, 'create'])->name('create');
    Route::post('/', [AdvertiserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdvertiserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdvertiserController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdvertiserController::class, 'destroy'])->name('destroy');
});

// CSV Import - AdvertiserController
Route::middleware(['auth', 'role:business_advertiser'])->group(function () {
    Route::post('/advertisements/import', [AdvertiserController::class, 'importCsv'])->name('advertisements.import');
});

// LandingPageController
Route::middleware(['auth', 'role:business_advertiser'])->group(function () {
    Route::get('/landing-page', [LandingPageController::class, 'index'])->name('landing.index');
    Route::get('/landing-page/create', [LandingPageController::class, 'create'])->name('landing.create');
    Route::post('/landing-page/create', [LandingPageController::class, 'store'])->name('landing.store');
    Route::get('/landing-page/edit', [LandingPageController::class, 'edit'])->name('landing.edit');
    Route::post('/landing-page/update', [LandingPageController::class, 'update'])->name('landing.update');
});

// Component preview (Blade based)
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
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

// ReviewController
Route::middleware('auth')->group(function () {
    Route::get('/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
});

// ProductController
Route::middleware('auth')->name('products.')->prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

// BusinessSettingsController
Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/settings', [BusinessSettingsController::class, 'edit'])->name('profile.settings');
    Route::put('/settings', [BusinessSettingsController::class, 'update'])->name('profile.settings.update');
});
// return view calendar
Route::middleware(['auth', 'role:business_advertiser'])->group(function () {
    Route::get('/profile/calendar', [CalendarController::class, 'index'])->name('profile.calendar');
    Route::get('/ads-calendar', [CalendarController::class, 'adsCalendar'])->name('advertisements.ad-calendar');
});

// Catch-all for public landing pages
Route::get('/{slug}', [LandingPageController::class, 'show'])->name('landing.show');

Route::middleware('auth')->group(function () {
    Route::get('/reservations/{reservation}/return', [ReservationController::class, 'returnForm'])->name('reservations.return.form');
    Route::post('/reservations/{reservation}/return', [ReservationController::class, 'submitReturn'])->name('reservations.return.submit');

    Route::get('/return-requests/{reservation}/review', [ReservationController::class, 'reviewReturn'])->name('return.review');
    Route::post('/return-requests/{reservation}/finalize', [ReservationController::class, 'finalizeReturn'])->name('return.finalize');

});
