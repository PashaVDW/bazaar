<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use Laravel\Sanctum\PersonalAccessToken;

class AdvertisementApiController extends Controller
{
    public function tokenBasedIndex($token)
    {
        $accessToken = PersonalAccessToken::findToken($token);

        if (! $accessToken) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user = $accessToken->tokenable;

        $ads = $user->advertisements()->with('products')->get();

        return AdResource::collection($ads);
    }
}
