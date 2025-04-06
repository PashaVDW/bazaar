<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('account_type', 'customer')->first();
        $product = Product::where('type', 'rental')->first();

        if ($user && $product) {
            Reservation::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'stock_index' => 0,
                'start_time' => Carbon::now(),
                'end_time' => Carbon::now()->addDays(5),
                'returned_at' => Carbon::now()->addDays(6),
                'return_photo_path' => 'returns/sample.jpg',
                'wear_percentage' => 15,
            ]);
        }
    }
}
