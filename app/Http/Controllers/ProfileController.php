<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profile.index');
    }

    public function purchaseHistory()
    {
        $purchases = Auth::user()
            ->purchases()
            ->with(['ad'])
            ->whereNotNull('purchased_at')
            ->orderByDesc('purchased_at')
            ->paginate(5);

        return view('purchases.index', compact('purchases'));
    }

    public function showPurchase(int $id)
    {
        $purchase = Auth::user()->purchases()->with('ads')->findOrFail($id);

        return view('purchases.show', [
            'purchase' => $purchase,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
