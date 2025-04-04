<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContractBusinessFlowTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testBusinessUserCanUploadAndViewContract(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email' => 'business@example.com',
            'password' => bcrypt('password'),
            'account_type' => 'business',
        ]);

        $business = Business::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/profile')
                ->visit('/profile/contract/upload')
                ->assertSee('Upload a Signed Contract')
                ->attach('contract_file', __DIR__ . '/files/sample.pdf')
                ->press('Upload Contract')
                ->assertPathIs('/profile/contract')
                ->assertSee('Signed Contract')
                ->assertSee('Download')
                ->assertSee('MB');
        });

        Storage::disk('public')->assertExists('contracts/sample.pdf');
    }
}
