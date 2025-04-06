<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function purchaseHistory()
    {
        $purchases = Auth::user()
            ->purchases()
            ->with(['products.ad'])
            ->whereNotNull('purchased_at')
            ->orderByDesc('purchased_at')
            ->paginate(5);

        return view('purchases.index', compact('purchases'));
    }

    public function showPurchase(int $id)
    {
        $purchase = Auth::user()
            ->purchases()
            ->with('products.ad')
            ->findOrFail($id);

        return view('purchases.show', compact('purchase'));
    }
}
