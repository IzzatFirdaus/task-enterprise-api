<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed the built-in RBAC roles.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super_admin',
                'description' => 'Full system access with complete administrative control.',
                'is_system' => true,
            ],
            [
                'name' => 'admin',
                'description' => 'User and task management access without super-admin privileges.',
                'is_system' => true,
            ],
            [
                'name' => 'moderator',
                'description' => 'Task moderation and operational oversight without user management access.',
                'is_system' => true,
            ],
            [
                'name' => 'user',
                'description' => 'Standard end-user access with task-level permissions.',
                'is_system' => true,
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'is_system' => $role['is_system'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
