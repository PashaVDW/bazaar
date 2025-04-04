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
    public function uploadContract()
    {
        $businesses = Business::with('user')->latest()->get();

        return view('admin.contracts.upload', compact('businesses'));
    }
    public function showContract($id)
    {
        $business = Business::with('user')->findOrFail($id);

        return view('admin.contracts.show', compact('business'));
    }
    public function deleteContract($id)
    {
        $business = Business::with('user')->findOrFail($id);

        if ($business->contract_file_path) {
            \Storage::delete($business->contract_file_path);
            $business->contract_file_path = null;
            $business->save();
        }

        return redirect()->route('admin.contracts.index')->with('success', 'Contract deleted successfully.');
    }
}
