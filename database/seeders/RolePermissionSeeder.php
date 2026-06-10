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
        // Clear cache
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Permissions
    Permission::create(['name' => 'manage students']);
    Permission::create(['name' => 'manage fees']);
    Permission::create(['name' => 'view results']);
    Permission::create(['name' => 'take attendance']);
    Permission::create(['name' => 'publish results']);

    // Roles
    $admin = Role::create(['name' => 'admin']);
    $teacher = Role::create(['name' => 'teacher']);
    $student = Role::create(['name' => 'student']);

    // Assign permissions to roles
    $admin->givePermissionTo(Permission::all());

    $teacher->givePermissionTo([
        'take attendance',
        'view results',
        'publish results',
    ]);

    $student->givePermissionTo([
        'view results',
    ]);
    }
}
