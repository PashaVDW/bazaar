<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdvertisementRequest;
use App\Http\Requests\UpdateAdvertisementRequest;
use App\Http\Requests\UploadCsvRequest;
use App\Imports\AdsImport;
use App\Models\Ad;
use App\Models\Product;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class AdvertiserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $advertisements = $user->advertisements()->latest()->get();

        foreach ($advertisements as $ad) {
            if ($ad->qr_code_path && Storage::disk('public')->exists(str_replace('storage/', '', $ad->qr_code_path))) {
                $ad->qr_svg = Storage::disk('public')->get(str_replace('storage/', '', $ad->qr_code_path));
            } else {
                $ad->qr_svg = null;
            }
        }

        return view('ads.index', compact('advertisements'));
    }

    public function create()
    {
        $products = Auth::user()->products;

        return view('ads.create', compact('products'));
    }

    public function store(StoreAdvertisementRequest $request, QrCodeService $qrCodeService)
    {
        $data = $request->validated();

        $data['image'] = $request->file('image')->store('ads', 'public');
        $data['user_id'] = Auth::id();

        $ad = Ad::create($data);

        if ($request->has('main_product_id')) {
            Product::where('id', $request->main_product_id)->update([
                'ad_id' => $ad->id,
                'is_main' => true,
            ]);
        }

        if ($request->has('sub_product_ids')) {
            Product::whereIn('id', $request->sub_product_ids)->update([
                'ad_id' => $ad->id,
                'is_main' => false,
            ]);
        }

        $qrPath = $qrCodeService->generateForAd($ad);
        $ad->update(['qr_code_path' => $qrPath]);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement created successfully.');
    }

    public function edit(string $id)
    {
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $products = Auth::user()->products;

        return view('ads.edit', compact('ad', 'products'));
    }

    public function update(UpdateAdvertisementRequest $request, string $id)
    {
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('ads', 'public');
        } else {
            $data['image'] = $ad->image;
        }

        $ad->update($data);

        return redirect()->route('advertisements.index')->with('success', 'Advertisement updated successfully.');
    }

    public function show(string $id) {}

    public function destroy(string $id)
    {
        $ad = Ad::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $ad->delete();

        return redirect()->route('advertisements.index')->with('success', 'Advertisement deleted.');
    }

    public function importCsv(UploadCsvRequest $request, QrCodeService $qrCodeService)
    {
        $validated = $request->validated();

        $file = $request->file('csv_file');

        $rows = array_map('str_getcsv', file($file->getRealPath()));
        if (count($rows) - 1 > 4) {
            return redirect()->back()->with('error', 'You may only import up to 4 records at once.');
        }

        Excel::import(new AdsImport($qrCodeService), $file);

        return redirect()->route('advertisements.index')->with('success', 'Advertisements imported successfully.');
    }
}
