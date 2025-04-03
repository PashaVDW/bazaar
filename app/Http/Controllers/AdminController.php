<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Business;

class AdminController extends Controller
{
    public function contractIndex()
    {
        $businesses = Business::with('user')->latest()->get();

        return view('admin.contracts.index', compact('businesses'));
    }
}
