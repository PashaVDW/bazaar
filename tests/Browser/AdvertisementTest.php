<?php

namespace Tests\Browser;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdvertisementTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->artisan('db:seed', ['--class' => 'RolePermissionSeeder']);
        $this->artisan('db:seed', ['--class' => 'UserRoleSeeder']);
    }

    /** @test */
    public function can_access_create_page()
    {
        $user = User::factory()->create()->assignRole('private_advertiser');

        $this->browse(fn (Browser $browser) => $browser->loginAs($user)
            ->visit(route('advertisements.create'))
            ->assertSee('Create Advertisement')
        );
    }

    /** @test */
    public function can_create_advertisement_minimal_fields()
    {
        $user = User::factory()->create()->assignRole('private_advertiser');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('advertisements.create'))
                ->type('title', 'Test Ad')
                ->type('description', 'Test Description')
                ->type('hourly_price', '25.50')
                ->attach('image', __DIR__.'/files/test-image.jpg')
                ->type('ads_starttime', now()->format('Y-m-d\TH:i'))
                ->type('ads_endtime', now()->addDay()->format('Y-m-d\TH:i'))
                ->select('type', 'sale')
                ->check('is_active')
                ->press('Create Advertisement')
                ->pause(1000)
                ->assertSee('Test Ad');
        });
    }

    /** @test */
    public function fails_validation_with_missing_required_fields()
    {
        $user = User::factory()->create()->assignRole('private_advertiser');

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('advertisements.create'))
                ->press('Create Advertisement')
                ->pause(500)
                ->assertPathIs('/advertisements/create');
        });
    }

    /** @test */
    public function cannot_create_more_than_four_ads()
    {
        $user = User::factory()->create()->assignRole('private_advertiser');
        Ad::factory(4)->create(['user_id' => $user->id]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit(route('advertisements.create'))
                ->type('title', 'Blocked Ad')
                ->type('description', 'Too many ads')
                ->type('hourly_price', '49.99')
                ->attach('image', __DIR__.'/files/test-image.jpg')
                ->type('ads_starttime', now()->format('Y-m-d\TH:i'))
                ->type('ads_endtime', now()->addDay()->format('Y-m-d\TH:i'))
                ->select('type', 'sale')
                ->check('is_active')
                ->press('Create Advertisement')
                ->pause(1000)
                ->assertSee('maximum of 4 advertisements');
        });
    }

    /** @test */
    public function can_delete_advertisement()
    {
        $user = User::factory()->create()->assignRole('private_advertiser');
        $ad = Ad::factory()->create([
            'user_id' => $user->id,
            'title' => 'Delete Me',
            'hourly_price' => 15.00,
        ]);

        $this->browse(function (Browser $browser) use ($user, $ad) {
            $browser->loginAs($user)
                ->visit(route('advertisements.index'))
                ->press('@delete-button-'.$ad->id)
                ->pause(200)
                ->whenAvailable('#delete-modal-'.$ad->id, function ($modal) {
                    $modal->press("Yes, I'm sure");
                })
                ->pause(800)
                ->assertDontSee('Delete Me');
        });
    }
}
