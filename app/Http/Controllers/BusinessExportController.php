<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BusinessExportController extends Controller
{
    public function export($id)
    {
        $business = Business::with('user')->findOrFail($id);

        $pdf = Pdf::loadView('admin.contracts.pdf.index', compact('business'));

        return $pdf->download("contract-{$business->id}.pdf");
    }
}
