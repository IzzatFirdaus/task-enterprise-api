<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Seed administrative accounts and assign the built-in roles.
     */
    public function run(): void
    {
        $roleNames = [
            'super_admin' => Role::SUPER_ADMIN,
            'admin' => Role::ADMIN,
            'moderator' => Role::MODERATOR,
            'user' => Role::USER,
        ];

        $roles = Role::query()->whereIn('name', array_values($roleNames))->get()->keyBy('name');

        $adminUsers = [
            [
                'name' => 'System Administrator',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => Role::SUPER_ADMIN,
            ],
            [
                'name' => 'Operations Manager',
                'email' => 'admin2@example.com',
                'password' => 'password',
                'role' => Role::ADMIN,
            ],
            [
                'name' => 'Community Moderator',
                'email' => 'moderator@example.com',
                'password' => 'password',
                'role' => Role::MODERATOR,
            ],
        ];

        foreach ($adminUsers as $adminUser) {
            $user = User::query()->firstOrCreate(
                ['email' => $adminUser['email']],
                [
                    'name' => $adminUser['name'],
                    'password' => bcrypt($adminUser['password']),
                    'email_verified_at' => now(),
                    'is_admin' => true,
                    'is_suspended' => false,
                ]
            );

            $role = $roles->get($adminUser['role']);

            if ($role) {
                DB::table('role_user')->updateOrInsert(
                    ['user_id' => $user->getKey(), 'role_id' => $role->getKey()],
                    ['assigned_at' => now(), 'created_at' => now(), 'updated_at' => now()]
                );
            }
        }
    }
}
