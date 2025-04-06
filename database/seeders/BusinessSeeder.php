<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\User;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('account_type', 'business')->get();

        foreach ($users as $user) {
            Business::factory()->create([
                'user_id' => $user->id,
                'company_name' => 'Company of '.$user->name,
                'kvk_number' => 'K'.str_pad($user->id, 8, '0', STR_PAD_LEFT),
                'vat_number' => 'NL'.rand(100000000,999999999).'B01',
                'phone' => '06123456'.$user->id,
                'contract_status' => 'signed',
            ]);
        }
    }
}
