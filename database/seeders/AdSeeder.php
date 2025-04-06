<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Services\QrCodeService;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();
        $qrCodeService = app(QrCodeService::class);

        $types = ['sale', 'rental', 'auction'];

        for ($i = 1; $i <= 20; $i++) {
            $type = $types[($i - 1) % count($types)];

            $ad = Ad::create([
                'user_id' => $user->id,
                'title' => strtoupper($type).' Ad #'.$i,
                'description' => 'Description for '.$type.' ad #'.$i,
                'image' => 'sample1.jpg',
                'ads_starttime' => now(),
                'ads_endtime' => now()->addDays(10),
                'is_active' => true,
            ]);

            $qrPath = $qrCodeService->generateForAd($ad);
            $ad->update(['qr_code_path' => $qrPath]);

            $product = Product::create([
                'user_id' => $user->id,
                'ad_id' => $ad->id,
                'name' => strtoupper($type).' Product #'.$i,
                'description' => 'Product description for '.$type.' product #'.$i,
                'price' => rand(10, 100),
                'type' => $type,
                'stock' => rand(1, 50),
                'image' => 'sample1.jpg',
            ]);

            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'title' => 'Review for '.$product->name,
                'content' => 'This is a review content for '.$product->name,
                'rating' => rand(3, 5),
            ]);
        }
    }
}
