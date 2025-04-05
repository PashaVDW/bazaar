<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;
use App\Models\User;
use Illuminate\Support\Str;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::factory()->create();
        }

        $types = ['sale', 'rental', 'auction'];

        for ($i = 1; $i <= 20; $i++) {
            Ad::create([
                'user_id' => $user->id,
                'title' => 'Ad title #' . $i,
                'description' => fake()->sentence(10),
                'hourly_price' => fake()->randomFloat(2, 10, 1000),
                'image' => 'sample' . rand(1, 5) . '.jpg',
                'ads_starttime' => now()->format('Y-m-d H:i:s'),
                'ads_endtime' => now()->addDays(rand(1, 10))->format('Y-m-d H:i:s'),
                'type' => $types[array_rand($types)],
                'is_active' => true,
            ]);
        }
    }
}
