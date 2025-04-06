<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContractBusinessFlowTest extends DuskTestCase
{
    public function test_business_user_can_upload_and_view_contract(): void
    {
        $admin = User::where('email', 'admin@bazaar.test')->firstOrFail();
        $businessUser = User::where('email', 'business1@bazaar.test')->firstOrFail();
        $business = $businessUser->business;

        Storage::disk('public')->put('contracts/sample.pdf', file_get_contents(__DIR__.'/files/sample.pdf'));

        $this->browse(function (Browser $browser) use ($businessUser) {
            $browser->visit('/login')
                ->type('email', $businessUser->email)
                ->type('password', 'password')
                ->press('Login')
                ->visit('/profile/contract')
                ->assertSee('Upload a Signed Contract')
                ->attach('contract_file', __DIR__.'/files/sample.pdf')
                ->press('Upload Contract')
                ->waitForLocation('/profile/contract')
                ->assertSee('Signed Contract')
                ->assertSee('Download')
                ->assertSee('MB');
        });

        Storage::disk('public')->assertExists('contracts/sample.pdf');
    }
}
