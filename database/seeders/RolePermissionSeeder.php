<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'create advertisements']);
        Permission::create(['name' => 'create rental advertisements']);
        Permission::create(['name' => 'create bids']);
        Permission::create(['name' => 'link advertisements']);
        Permission::create(['name' => 'view advertisement calendar']);

        Permission::create(['name' => 'upload csvs']);
        Permission::create(['name' => 'customize appearance']);
        Permission::create(['name' => 'set custom url']);
        Permission::create(['name' => 'create page layouts']);
        Permission::create(['name' => 'expose own api']);
        Permission::create(['name' => 'upload contracts']);
        Permission::create(['name' => 'export registration as pdf']);

        $private_advertiser = Role::create(['name' => 'private_advertiser']);
        $private_advertiser->givePermissionTo([
            'create advertisements',
            'create rental advertisements',
            'create bids',
            'link advertisements',
            'view advertisement calendar',
        ]);

        $business_advertiser = Role::create(['name' => 'business_advertiser']);
        $business_advertiser->givePermissionTo([
            'create advertisements',
            'create rental advertisements',
            'create bids',
            'link advertisements',
            'view advertisement calendar',
            'upload csvs',
            'customize appearance',
            'set custom url',
            'create page layouts',
            'expose own api',
            'upload contracts',
            'export registration as pdf',
        ]);

        Role::create(['name' => 'Super Admin']);
    }
}
