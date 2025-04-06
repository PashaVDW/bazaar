<?php

namespace Tests\Browser;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdvertisementTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_advertisement()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'account_type' => 'business_advertiser',
        ]);
        $user->assignRole('business_advertiser');

        $product1 = Product::factory()->create(['user_id' => $user->id]);
        $product2 = Product::factory()->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user, $product1, $product2) {
            $browser->loginAs($user)
                ->visit(route('advertisements.create'))
                ->type('title', 'Test Advertisement')
                ->type('description', 'This is a test description')
                ->attach('image', __DIR__ . '/files/test_image.jpg')
                ->type('ads_starttime', now()->addHour()->format('Y-m-d\TH:i'))
                ->type('ads_endtime', now()->addDays(5)->format('Y-m-d\TH:i'))
                ->select('main_product_id', $product1->id)
                ->select('sub_product_ids[]', $product2->id)
                ->check('is_active')
                ->press(__('messages.create'))
                ->waitForText(__('messages.your_advertisements'))
                ->assertPathIs(route('advertisements.index', [], false))
                ->assertSee('Test Advertisement');
        });
    }
}
