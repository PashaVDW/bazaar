<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => 'ads/default.jpg',
            'ads_starttime' => now(),
            'ads_endtime' => now()->addDay(),
            'type' => $this->faker->randomElement(['sale', 'rental', 'auction']),
            'is_active' => true,
            'hourly_price' => $this->faker->randomFloat(2, 10, 100),
        ];
    }
}
