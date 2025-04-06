<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $product = Product::first();
        $purchase = Purchase::first();

        if ($product && $purchase) {
            DB::table('product_purchase')->insert([
                'product_id' => $product->id,
                'purchase_id' => $purchase->id,
                'quantity' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
