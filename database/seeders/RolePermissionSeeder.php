<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions based on actual system features
        $permissions = [
            'manage inventory',
            'view inventory',
            'manage logs',
            'view logs',
            'manage ci monitoring',
            'view ci monitoring',
            'manage users',
            'view users',
            'manage roles',
            'view roles',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // create roles and assign created permissions
        $role = Role::firstOrCreate(['name' => 'System Admin']);
        $role->givePermissionTo(Permission::all());

        $userRole = Role::firstOrCreate(['name' => 'User']);
        $userRole->givePermissionTo([
            'view inventory',
            'view logs',
            'view ci monitoring',
            'view users',
            'view roles'
        ]);
    }
}
