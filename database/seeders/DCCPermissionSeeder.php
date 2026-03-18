<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DCCPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. BUAT PERMISSIONS UNTUK DEPARTMENT
        $departmentPermissions = [
            'view departments',
            'create departments',
            'edit departments',
            'delete departments',
        ];

        // 2. BUAT PERMISSIONS UNTUK SUBMISSION
        $submissionPermissions = [
            'view submissions',
            'create submissions',
            'edit submissions',
            'delete submissions',
        ];

        // Gabungkan semua permissions
        $allPermissions = array_merge($departmentPermissions, $submissionPermissions);

        // Buat permissions di database (hanya jika belum ada)
        foreach ($allPermissions as $permissionName) {
            Permission::firstOrCreate(
                ['name' => $permissionName, 'guard_name' => 'web'],
                ['name' => $permissionName, 'guard_name' => 'web']
            );
        }

        $this->command->info('DCC permissions created successfully!');
        $this->command->info('Total permissions: ' . count($allPermissions));
        $this->command->info('Permissions:');
        foreach ($allPermissions as $permission) {
            $this->command->info("  - {$permission}");
        }
    }
}