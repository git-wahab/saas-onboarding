<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view user listings'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create new users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit user information'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],
            
            ['name' => 'tenants.view', 'display_name' => 'View Tenants', 'description' => 'Can view tenant listings'],
            ['name' => 'tenants.create', 'display_name' => 'Create Tenants', 'description' => 'Can create new tenants'],
            ['name' => 'tenants.edit', 'display_name' => 'Edit Tenants', 'description' => 'Can edit tenant information'],
            ['name' => 'tenants.delete', 'display_name' => 'Delete Tenants', 'description' => 'Can delete tenants'],
            
            ['name' => 'billing.view', 'display_name' => 'View Billing', 'description' => 'Can view billing information'],
            ['name' => 'billing.edit', 'display_name' => 'Edit Billing', 'description' => 'Can edit billing information'],
            
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'description' => 'Can view roles'],
            ['name' => 'roles.manage', 'display_name' => 'Manage Roles', 'description' => 'Can create, edit, and delete roles'],
            
            ['name' => 'admin.dashboard', 'display_name' => 'Admin Dashboard', 'description' => 'Can access admin dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create roles
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super-admin'],
            [
                'display_name' => 'Super Administrator',
                'description' => 'Has all permissions and can manage everything'
            ]
        );

        $adminRole = Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'display_name' => 'Administrator',
                'description' => 'Can manage users, tenants, and billing'
            ]
        );

        $userRole = Role::firstOrCreate(
            ['name' => 'user'],
            [
                'display_name' => 'User',
                'description' => 'Regular user with basic permissions'
            ]
        );

        // Assign all permissions to super admin
        $allPermissions = Permission::all();
        $superAdminRole->permissions()->sync($allPermissions->pluck('id'));

        // Assign specific permissions to admin
        $adminPermissions = Permission::whereIn('name', [
            'users.view', 'users.create', 'users.edit',
            'tenants.view', 'tenants.create', 'tenants.edit', 'tenants.delete',
            'billing.view', 'billing.edit',
            'admin.dashboard'
        ])->get();
        $adminRole->permissions()->sync($adminPermissions->pluck('id'));

        // Create Super Admin User
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@admin.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        // Assign roles using direct database inserts to avoid the hasRole check
        // Super Admin Role
        if (!$superAdmin->roles()->where('role_id', $superAdminRole->id)->exists()) {
            $superAdmin->roles()->attach($superAdminRole->id);
        }

        // Admin Role
        if (!$admin->roles()->where('role_id', $adminRole->id)->exists()) {
            $admin->roles()->attach($adminRole->id);
        }

        $this->command->info('Admin users created successfully!');
        $this->command->info('Super Admin: superadmin@admin.com / password123');
        $this->command->info('Admin: admin@admin.com / password123');
    }
}
