<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        // Check if permission exists before creating
        $viewUsers = Permission::firstOrCreate(['name' => 'view users']);
        $viewPosts = Permission::firstOrCreate(['name' => 'view posts']);

        // Check if roles exist before assigning
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);

        // Assign permissions
        if (!$adminRole->hasPermissionTo('view users')) {
            $adminRole->givePermissionTo($viewUsers);
        }

        if (!$adminRole->hasPermissionTo('view posts')) {
            $adminRole->givePermissionTo($viewPosts);
        }

        if (!$userRole->hasPermissionTo('view posts')) {
            $userRole->givePermissionTo($viewPosts);
        }
    }
}
