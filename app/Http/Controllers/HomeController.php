<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Services\AdSearchService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $adSearchService;

    public function __construct(AdSearchService $adSearchService)
    {
        $this->adSearchService = $adSearchService;
    }

    public function index(Request $request)
    {
        $ads = $this->adSearchService->search($request);

        return view('welcome', compact('ads'));
    }

    public function favorite(Ad $ad)
    {
        auth()->user()->favorites()->syncWithoutDetaching([$ad->id]);

        return back()->with('success', 'Toegevoegd aan favorieten.');
    }

    public function unfavorite(Ad $ad)
    {
        auth()->user()->favorites()->detach($ad->id);

        return back()->with('success', 'Verwijderd uit favorieten.');
    }
}
