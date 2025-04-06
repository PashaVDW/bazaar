<?php

use App\Http\Controllers\Api\AdvertisementApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API
Route::get('/my-ads/{token}', [AdvertisementApiController::class, 'tokenBasedIndex']);
