<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('account_type', 'customer')->first();
        $product = Product::first();

        if ($user && $product) {
            Review::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'title' => 'Solid product',
                'content' => 'Very good quality. Worth the price.',
                'rating' => 5,
            ]);
        }
    }
}
