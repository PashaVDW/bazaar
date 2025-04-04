<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class BusinessExportController extends Controller
{
    public function export($id)
    {
        $business = Business::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('admin.contracts.pdf.index', compact('business'));

        return $pdf->download("contract-{$business->id}.pdf");
    }

    public function showContract()
    {
        $business = Auth::user()?->business;
        $fileSize = null;
        $uploadTime = null;
    
        if ($business && $business->contract_file_path) {
            $path = storage_path('app/public/' . $business->contract_file_path);
            
            if (file_exists($path)) {
                $fileSize = round(filesize($path) / 1048576, 2);
                $uploadTime = Carbon::parse($business->updated_at)->format('H:i');
            }
        }

        return view('profile.contract', compact('business', 'fileSize', 'uploadTime'));
    }

    public function saveUploadedContract(Request $request)
    {
        $business = Auth::user()->business;

        if (!$business) abort(403);

        $request->validate([
            'contract_file' => 'required|file|mimes:pdf|max:2048',
        ]);

        $path = $request->file('contract_file')->store('contracts', 'public');

        if ($business->contract_file_path) {
            Storage::disk('public')->delete($business->contract_file_path);
        }

        $business->contract_file_path = $path;
        $business->contract_signed_by_business = now();
        $business->contract_status = 'signed';
        $business->save();

        return redirect()->route('profile.contract')->with('success', 'Contract uploaded successfully.');
    }

}
