<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Add student',
            'Manage students',
            'Add teacher',
            'Manage teacher',
            'Roll assignment',
            'Promotion',
            'Manage subject',
            'Manage class',
            'Manage section',
            'Manage attendance',
            'View attendance',
            'Manage exam',
            'Manage result',
            'View results',
            'manage fees',
            'View ledger',
        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }
    }
}
