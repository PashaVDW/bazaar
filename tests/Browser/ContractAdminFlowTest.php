<?php

namespace Tests\Browser;

use App\Models\Business;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContractAdminFlowTest extends DuskTestCase
{
    public function test_admin_can_view_and_download_business_contract(): void
    {
        $admin = User::where('email', 'admin@bazaar.test')->firstOrFail();
        $business = Business::firstOrFail();

        $business->contract_file_path = 'contracts/sample.pdf';
        $business->contract_status = 'signed';
        $business->save();

        Storage::disk('public')->put('contracts/sample.pdf', 'Test content');

        $this->browse(function (Browser $browser) use ($admin, $business) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'password')
                ->press('Login')
                ->visit('/admin/contracts')
                ->assertSee($business->company_name)
                ->assertSee('Download PDF')
                ->assertSee('View Signed');
        });

        Storage::disk('public')->assertExists('contracts/sample.pdf');
    }
}
