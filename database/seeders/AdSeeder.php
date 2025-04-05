<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (! $user) {
            $user = User::factory()->create();
        }

        for ($i = 1; $i <= 20; $i++) {
            Ad::create([
                'user_id' => 1,
                'title' => 'Ad title #1',
                'description' => 'Some description',
                'image' => 'sample1.jpg',
                'ads_starttime' => now(),
                'ads_endtime' => now()->addDays(10),
                'is_active' => true,
            ]);

        }
    }
}
