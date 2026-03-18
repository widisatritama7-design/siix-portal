<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat permissions untuk User Management
        $userPermissions = [
            'view users',
            'create users',
            'edit users',
            'delete users',
        ];

        // Buat permissions untuk Role Management
        $rolePermissions = [
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
        ];

        // Buat permissions untuk Permission Management
        $permissionPermissions = [
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
        ];

        // Gabungkan semua permissions
        $allPermissions = array_merge($userPermissions, $rolePermissions, $permissionPermissions);

        // Buat permissions di database
        foreach ($allPermissions as $permissionName) {
            Permission::create(['name' => $permissionName, 'guard_name' => 'web']);
        }

        $this->command->info('Permissions created successfully!');
    }
}