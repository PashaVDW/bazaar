<?php

namespace Tests\Browser;

use App\Models\Business;
use App\Models\User;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class BusinessContractsTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function test_admin_can_view_contracts(): void
    {
        $this->browse(function (Browser $browser) {
            $admin = User::where('email', 'admin@bazaar.test')->first();

            $browser->loginAs($admin)
                ->visit('/admin/contracts')
                ->assertSee('Business Contracts')
                ->assertSee('Download PDF');
        });
    }

    public function test_admin_can_download_pdf_http()
    {
        $admin = User::where('email', 'admin@bazaar.test')->firstOrFail();
        $business = Business::firstOrFail();

        $response = $this->actingAs($admin)->get(route('admin.business.export.pdf', $business->id));

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
        $response->assertHeader('Content-Disposition', 'attachment; filename=contract-'.$business->id.'.pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    protected function waitForFile(string $path, int $seconds = 5)
    {
        $attempts = $seconds * 2;
        while ($attempts-- > 0 && ! file_exists($path)) {
            usleep(500000); // 0.5 sec
        }
    }

    public function test_guest_cannot_access_contracts(): void
    {
        $this->browse(function (Browser $browser) {
            $guest = User::where('account_type', 'private_advertiser')->first();
            $browser->loginAs($guest)
                ->visit('/admin/contracts')
                ->assertSee('403');
        });
    }
}
