<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdSearchService;

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
}
