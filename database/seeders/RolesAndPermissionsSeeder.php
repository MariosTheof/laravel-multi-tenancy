<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view projects', 'view own projects', 'edit projects', 'delete projects', 'create projects',
            'view companies', 'view own companies', 'create companies', 'delete company',
            'edit own companies', 'delete own companies',
            'edit own projects', 'delete own projects'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign existing permissions
        $admin = Role::create(['name' => 'admin']);
        // Admin gets all permissions, including new specific ones
        $admin->givePermissionTo(Permission::all());

        $moderator = Role::create(['name' => 'moderator']);
        // Moderators can view all projects and companies, and modify only their own companies
        $moderator->givePermissionTo([
            'view projects', 'view own projects', 'view companies',
            'view own companies', 'edit own companies', 'delete own companies',
            'edit own projects', 'delete own projects'
        ]);
    }
}
