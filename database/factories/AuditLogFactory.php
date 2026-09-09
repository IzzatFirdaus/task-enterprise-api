<?php

namespace Database\Factories;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AuditLog>
 */
class AuditLogFactory extends Factory
{
    protected $model = AuditLog::class;

    public function definition(): array
    {
        return [
            'admin_id' => User::factory(),
            'action' => fake()->randomElement(['task_reassigned', 'task_status_updated', 'task_deleted', 'user_suspended', 'settings_updated']),
            'model_type' => fake()->randomElement(['Task', 'User', 'Settings']),
            'model_id' => fake()->numberBetween(1, 100),
            'changes' => [
                'before' => ['status' => 'pending'],
                'after' => ['status' => 'completed'],
            ],
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
            'created_at' => now(),
        ];
    }
}
