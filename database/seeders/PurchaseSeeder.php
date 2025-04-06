<?php

namespace Database\Seeders;

use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('account_type', 'customer')->first();

        if ($user) {
            Purchase::create([
                'user_id' => $user->id,
                'purchased_at' => now(),
            ]);
        }
    }
}
