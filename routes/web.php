<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertiserController;
use App\Http\Controllers\BusinessExportController;
use App\Http\Controllers\BusinessSettingsController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DeveloperSettingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::post('/ads/{ad}/favorite', [HomeController::class, 'favorite'])->name('ads.favorite');
    Route::delete('/ads/{ad}/unfavorite', [HomeController::class, 'unfavorite'])->name('ads.unfavorite');
    Route::get('/ads/{ad}', [HomeController::class, 'show'])->name('ads.show');
});

Route::middleware(['auth', 'role:Super Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/businesses/{id}/export-pdf', [BusinessExportController::class, 'export'])->middleware('permission:export registration as pdf')->name('business.export.pdf');
    Route::get('/contracts', [AdminController::class, 'contractIndex'])->name('contracts.index');
    Route::get('/contracts/{business}/upload', [AdminController::class, 'uploadContract'])->middleware('permission:upload contracts')->name('upload');
    Route::post('/contracts/{business}/upload', [AdminController::class, 'saveUploadedContract'])->middleware('permission:upload contracts')->name('contracts.upload.save');
});

Route::middleware('auth')->name('profile.')->group(function () {
    Route::get('/profile/purchases/{timestamp}', [ProfileController::class, 'showPurchase'])->name('purchases.show');
    Route::get('/purchaseHistory', [ProfileController::class, 'purchaseHistory'])->name('purchaseHistory');
    Route::get('/profile', [ProfileController::class, 'index'])->name('index');
    Route::middleware(['role:business_advertiser', 'permission:upload contracts'])->post('/profile/contract/upload', [BusinessExportController::class, 'saveUploadedContract'])->name('contract.upload.save');
    Route::middleware(['role:business_advertiser'])->get('/profile/contract', [BusinessExportController::class, 'showContract'])->name('contract');
    Route::get('/rentalHistory', [ProfileController::class, 'rentalHistory'])->name('rentalHistory');
});

Route::middleware(['auth', 'permission:create advertisements'])->name('advertisements.')->prefix('advertisements')->group(function () {
    Route::get('/', [AdvertiserController::class, 'index'])->name('index');
    Route::get('/create', [AdvertiserController::class, 'create'])->middleware('permission:create rental advertisements')->name('create');
    Route::post('/', [AdvertiserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [AdvertiserController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AdvertiserController::class, 'update'])->name('update');
    Route::delete('/{id}', [AdvertiserController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth', 'role:business_advertiser', 'permission:upload csvs'])->group(function () {
    Route::post('/advertisements/import', [AdvertiserController::class, 'importCsv'])->name('advertisements.import');
});

Route::middleware(['auth', 'role:business_advertiser'])->group(function () {
    Route::get('/landing-page', [LandingPageController::class, 'index'])->middleware('permission:create page layouts')->name('landing.index');
    Route::get('/landing-page/create', [LandingPageController::class, 'create'])->middleware('permission:create page layouts')->name('landing.create');
    Route::post('/landing-page/create', [LandingPageController::class, 'store'])->middleware('permission:create page layouts')->name('landing.store');
    Route::get('/landing-page/edit', [LandingPageController::class, 'edit'])->middleware('permission:create page layouts')->name('landing.edit');
    Route::post('/landing-page/update', [LandingPageController::class, 'update'])->middleware('permission:create page layouts')->name('landing.update');
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

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/checkout', [CartController::class, 'checkout'])->middleware('auth')->name('cart.checkout');

Route::middleware('auth')->group(function () {
    Route::get('/review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/store', [ReviewController::class, 'store'])->name('review.store');
});

Route::middleware(['auth', 'role:private_advertiser|business_advertiser'])->name('products.')->prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/create', [ProductController::class, 'create'])->name('create');
    Route::post('/', [ProductController::class, 'store'])->name('store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
    Route::put('/{product}', [ProductController::class, 'update'])->name('update');
    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->prefix('profile')->group(function () {
    Route::get('/settings', [BusinessSettingsController::class, 'edit'])->middleware('permission:customize appearance')->name('profile.settings');
    Route::put('/settings', [BusinessSettingsController::class, 'update'])->middleware('permission:customize appearance')->name('profile.settings.update');
});

Route::middleware(['auth', 'permission:view advertisement calendar'])->group(function () {
    Route::get('/profile/calendar', [CalendarController::class, 'index'])->name('profile.calendar');
    Route::get('/ads-calendar', [CalendarController::class, 'adsCalendar'])->name('advertisements.ad-calendar');
});

Route::middleware('auth')->group(function () {
    Route::get('/reservations/{reservation}/return', [ReservationController::class, 'returnForm'])->name('reservations.return.form');
    Route::post('/reservations/{reservation}/return', [ReservationController::class, 'submitReturn'])->name('reservations.return.submit');

    Route::get('/return-requests/{reservation}/review', [ReservationController::class, 'reviewReturn'])->name('return.review');
    Route::post('/return-requests/{reservation}/finalize', [ReservationController::class, 'finalizeReturn'])->name('return.finalize');
});

Route::middleware(['auth', 'role:business_advertiser', 'permission:expose own api'])->prefix('developer')->name('developer.')->group(function () {
    Route::get('/settings', [DeveloperSettingsController::class, 'index'])->name('index');
    Route::post('/createToken', [DeveloperSettingsController::class, 'createToken'])->name('createToken');
    Route::delete('/developer/tokens/{id}', [DeveloperSettingsController::class, 'destroy'])->name('destroyToken');
});

Route::get('/{slug}', [LandingPageController::class, 'show'])->name('landing.show');
