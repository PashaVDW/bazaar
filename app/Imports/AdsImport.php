<?php

namespace App\Imports;

use App\Models\Ad;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $ad = Ad::create([
            'user_id' => auth()->id(),
            'title' => $row['title'],
            'description' => $row['description'],
            'image' => $row['image_url'],
            'ads_starttime' => $row['starttime'],
            'ads_endtime' => $row['endtime'],
            'is_active' => $row['is_active'] ?? 0,
        ]);

        $product = Product::create([
            'user_id' => auth()->id(),
            'ad_id' => $ad->id,
            'name' => $row['product_name'],
            'description' => $row['product_description'] ?? '',
            'price' => $row['price'],
            'type' => $row['type'],
            'stock' => $row['stock'] ?? 0,
        ]);

        return $ad;
    }
}
