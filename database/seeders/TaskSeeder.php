<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Alex Morgan', 'email' => 'alex@example.com'],
            ['name' => 'Jordan Lee', 'email' => 'jordan@example.com'],
            ['name' => 'Taylor Smith', 'email' => 'taylor@example.com'],
        ];
        $statuses = ['pending', 'in_progress', 'completed', 'pending', 'completed'];
        $titles = ['Plan quarterly roadmap', 'Review production metrics', 'Prepare stakeholder update', 'Refine onboarding flow', 'Archive completed sprint'];

        foreach ($users as $userData) {
            $user = User::factory()->create($userData);

            foreach ($statuses as $index => $status) {
                $createdAt = CarbonImmutable::now()->subDays(5 - $index);

                Task::create([
                    'user_id' => $user->getKey(),
                    'title' => $titles[$index],
                    'description' => 'Coordinate the next delivery milestone with the project team.',
                    'status' => $status,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);
            }
        }
    }
}
