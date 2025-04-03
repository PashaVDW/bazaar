<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;

class BusinessContractController extends Controller
{
    public function index()
    {
        $businesses = Business::with('user')->latest()->get();

        return view('admin.contracts.index', compact('businesses'));
    }
}
