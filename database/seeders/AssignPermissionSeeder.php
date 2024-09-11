<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles
        $adminRole = Role::findByName('admin');
        $userRole = Role::findByName('user');

        $permissions = [
            'view users',
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
        ];

        // Assign permissions to the admin role, but only if not already assigned
        foreach ($permissions as $permissionName) {
            $permission = Permission::findOrCreate($permissionName);
            if (!$adminRole->hasPermissionTo($permission)) {
                $adminRole->givePermissionTo($permission);
            }
        }

        // Assign only 'view posts' permission to the user role
        $viewPosts = Permission::findOrCreate('view posts');
        if (!$userRole->hasPermissionTo($viewPosts)) {
            $userRole->givePermissionTo($viewPosts);
        }
    }
}
