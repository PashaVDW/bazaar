<?php

namespace Tests\Browser;

use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Storage;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ContractAdminFlowTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function testAdminCanViewAndDownloadBusinessContract(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'account_type' => 'admin',
        ]);

        $user = User::factory()->create([
            'email' => 'biz@example.com',
            'password' => bcrypt('password'),
            'account_type' => 'business',
        ]);

        $business = Business::factory()->create([
            'user_id' => $user->id,
            'contract_file_path' => 'contracts/sample.pdf',
        ]);

        Storage::disk('public')->put('contracts/sample.pdf', 'Test content');

        $this->browse(function (Browser $browser) use ($admin, $business) {
            $browser->visit('/login')
                ->type('email', $admin->email)
                ->type('password', 'admin123')
                ->press('Login')
                ->visit('/admin/contracts')
                ->assertSee($business->company_name)
                ->assertSee('Download PDF')
                ->assertSee('View Signed')
                ->clickLink('Download PDF');
        });

        Storage::disk('public')->assertExists('contracts/sample.pdf');
    }
}
