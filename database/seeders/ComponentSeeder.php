<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Component;

class ComponentSeeder extends Seeder
{
    public function run(): void
    {
        Component::create([
            'name' => 'About Us',
            'view_path' => 'components.landing_components.about-us',
        ]);
        Component::create([
            'name' => 'Contact Section',
            'view_path' => 'components.landing_components.contact',
        ]);
        Component::create([
            'name' => 'Ad Showcase',
            'view_path' => 'components.landing_components.ads',
        ]);
        Component::create([
            'name' => 'Customer Reviews',
            'view_path' => 'components.landing_components.reviews',
        ]);
        Component::create([
            'name' => 'Business Values',
            'view_path' => 'components.landing_components.values',
        ]);
    }
}
