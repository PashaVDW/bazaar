<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $adminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@bazaar.test',
            'password' => bcrypt('password'),
            'account_type' => 'admin',
        ]);
        $adminUser->assignRole('Super Admin');

        for ($i = 1; $i <= 3; $i++) {
            $privateUser = User::create([
                'name' => "Private User $i",
                'email' => "private$i@bazaar.test",
                'password' => bcrypt('password'),
                'account_type' => 'private_advertiser',
            ]);
            $privateUser->assignRole('private_advertiser');
        }

        for ($i = 1; $i <= 3; $i++) {
            $bussinesUser = User::create([
                'name' => "Business User $i",
                'email' => "business$i@bazaar.test",
                'password' => bcrypt('password'),
                'account_type' => 'business_advertiser',
            ]);
            $bussinesUser->assignRole('business_advertiser');

            Business::create([
                'user_id' => $bussinesUser->id,
                'company_name' => "Business BV $i",
                'kvk_number' => '12345678'.$i,
                'vat_number' => 'NL00009999'.$i,
                'phone' => '06123456'.$i,
                'notes' => 'Seeded test business',
                'contract_status' => 'pending',
            ]);
        }
    }
}
