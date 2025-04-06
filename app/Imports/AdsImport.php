<?php

namespace App\Imports;

use App\Models\Ad;
use App\Models\Product;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdsImport implements ToModel, WithHeadingRow
{
    protected QrCodeService $qrCodeService;

    public function __construct(QrCodeService $qrCodeService)
    {
        $this->qrCodeService = $qrCodeService;
    }

    public function model(array $row)
    {
        $ad = Ad::create([
            'user_id' => Auth::id(),
            'title' => $row['advertisement_title'],
            'description' => $row['advertisement_description'],
            'image' => 'sample1.jpg',
            'ads_starttime' => $row['start_date_and_time'],
            'ads_endtime' => $row['end_date_and_time'],
            'is_active' => $row['is_active'] ?? 0,
        ]);

        $qrPath = $this->qrCodeService->generateForAd($ad);
        $ad->update(['qr_code_path' => $qrPath]);

        Product::create([
            'user_id' => Auth::id(),
            'ad_id' => $ad->id,
            'name' => $row['product_name'],
            'description' => $row['product_description'] ?? '',
            'price' => $row['product_price'],
            'type' => $row['product_type'] ?? 'sale',
            'stock' => $row['product_stock'] ?? 0,
        ]);

        return $ad;
    }
}
