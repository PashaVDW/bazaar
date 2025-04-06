<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'create advertisements',
            'create products',
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $privateAdvertiser = Role::firstOrCreate(['name' => 'private_advertiser']);
        $privateAdvertiser->givePermissionTo([
            'create advertisements',
            'create products',
            'create rental advertisements',
            'create bids',
            'link advertisements',
            'view advertisement calendar',
        ]);

        $businessAdvertiser = Role::firstOrCreate(['name' => 'business_advertiser']);
        $businessAdvertiser->givePermissionTo($permissions);

        Role::firstOrCreate(['name' => 'Super Admin']);
    }
}
