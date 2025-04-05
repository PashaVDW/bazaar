<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function contractIndex()
    {
        $businesses = Business::with('user')->latest()->get();
        $businessesWithContracts = Business::whereNotNull('contract_file_path')->get();

        return view('admin.contracts.index', compact('businesses', 'businessesWithContracts'));
    }

    public function uploadContract(Business $business)
    {
        return view('admin.contracts.upload', compact('business'));
    }

    public function saveUploadedContract(Request $request, Business $business)
    {
        $request->validate([
            'contract_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $path = $request->file('contract_file')->store('contracts', 'public');

        if ($business->contract_file_path) {
            \Storage::disk('public')->delete($business->contract_file_path);
        }
        $business->contract_signed_by_admin = now();
        $business->contract_file_path = $path;
        $business->contract_status = 'signed';
        $business->save();

        return redirect()->route('admin.contracts.index')->with('success', 'Contract uploaded successfully.');
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
