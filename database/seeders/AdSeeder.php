<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        for ($i = 1; $i <= 20; $i++) {
            $ad = Ad::create([
                'user_id' => $user->id,
                'title' => 'Ad title #' . $i,
                'description' => 'Some description',
                'image' => 'sample1.jpg',
                'ads_starttime' => now(),
                'ads_endtime' => now()->addDays(10),
                'is_active' => true,
            ]);

            $product = Product::create([
                'user_id' => $user->id,
                'ad_id' => $ad->id,
                'name' => 'Product #' . $i,
                'description' => 'Product description',
                'price' => rand(10, 100),
                'type' => 'sale',
                'stock' => rand(1, 50),
                'image' => 'sample1.jpg',
            ]);

            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'title' => 'Review for Product #' . $i,
                'content' => 'This is a review content for product #' . $i,
                'rating' => rand(3, 5),
            ]);
        }
    }
}
