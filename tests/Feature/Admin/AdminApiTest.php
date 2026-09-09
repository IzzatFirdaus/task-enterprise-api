<?php

namespace Tests\Feature\Admin;

use App\Models\AuditLog;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::seedDefaults();
    }

    private function createUserWithRole(string $roleName): User
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $user->roles()->attach(Role::query()->where('name', $roleName)->value('id'), [
            'assigned_at' => now(),
        ]);

        return $user->fresh();
    }

    public function test_super_admin_can_list_all_users(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);
        User::factory()->count(2)->create();

        $this->actingAs($superAdmin, 'sanctum')
            ->getJson('/api/v1/admin/users')
            ->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta'])
            ->assertJsonMissing(['password']);
    }

    public function test_admin_can_list_users_but_not_view_audit_logs(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/users')
            ->assertOk();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/audit-logs')
            ->assertForbidden()
            ->assertJsonPath('error.code', 'forbidden');
    }

    public function test_non_admin_cannot_access_admin_api(): void
    {
        $user = $this->createUserWithRole(Role::USER);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/admin/users')
            ->assertForbidden()
            ->assertJsonPath('error.code', 'forbidden');
    }

    public function test_suspended_user_cannot_access_admin_api(): void
    {
        $user = $this->createUserWithRole(Role::USER);
        $token = $user->createToken('test')->plainTextToken;

        $this->withToken($token)
            ->getJson('/api/v1/user')
            ->assertOk();

        $this->withToken($token)
            ->postJson('/api/v1/logout')
            ->assertNoContent();

        $this->withToken($token)
            ->getJson('/api/v1/user')
            ->assertUnauthorized()
            ->assertJsonPath('error.code', 'unauthenticated');
    }

    public function test_admin_can_suspend_user_and_log_action(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $target = User::factory()->create();

        $this->actingAs($admin, 'sanctum')
            ->postJson("/api/v1/admin/users/{$target->id}/suspend", [
                'reason' => 'Policy violation',
            ])
            ->assertOk()
            ->assertJsonPath('message', 'User suspended successfully.');

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'is_suspended' => true,
            'suspension_reason' => 'Policy violation',
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'admin_id' => $admin->id,
            'action' => 'user_suspended',
            'model_type' => 'User',
            'model_id' => $target->id,
        ]);
    }

    public function test_admin_cannot_suspend_another_admin_only_super_admin(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $targetAdmin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->postJson("/api/v1/admin/users/{$targetAdmin->id}/suspend", [
                'reason' => 'Test',
            ])
            ->assertForbidden();

        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($superAdmin, 'sanctum')
            ->postJson("/api/v1/admin/users/{$targetAdmin->id}/suspend", [
                'reason' => 'Test',
            ])
            ->assertOk();
    }

    public function test_super_admin_can_view_audit_logs(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);
        AuditLog::factory()->count(3)->create();

        $this->actingAs($superAdmin, 'sanctum')
            ->getJson('/api/v1/admin/audit-logs')
            ->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_audit_logs_created_for_admin_actions(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);
        $target = User::factory()->create();

        $this->actingAs($superAdmin, 'sanctum')
            ->postJson("/api/v1/admin/users/{$target->id}/suspend", ['reason' => 'Test'])
            ->assertOk();

        $this->assertDatabaseHas('audit_logs', [
            'admin_id' => $superAdmin->id,
            'action' => 'user_suspended',
            'model_type' => 'User',
            'model_id' => $target->id,
        ]);
    }

    public function test_task_reassignment_updates_owner_and_logs(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $task = Task::factory()->create();
        $newOwner = User::factory()->create();

        $this->actingAs($admin, 'sanctum')
            ->putJson("/api/v1/admin/tasks/{$task->id}", [
                'user_id' => $newOwner->id,
            ])
            ->assertOk()
            ->assertJsonPath('message', 'Task reassigned.');

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'user_id' => $newOwner->id,
        ]);

        $this->assertDatabaseHas('audit_logs', [
            'admin_id' => $admin->id,
            'action' => 'task_reassigned',
            'model_type' => 'Task',
            'model_id' => $task->id,
        ]);
    }

    public function test_bulk_task_deletion_logged_per_task(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $tasks = Task::factory()->count(3)->create();

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/admin/tasks/bulk-action', [
                'task_ids' => $tasks->pluck('id')->toArray(),
                'action' => 'delete',
            ])
            ->assertOk()
            ->assertJsonPath('processed', 3);

        foreach ($tasks as $task) {
            $this->assertSoftDeleted('tasks', ['id' => $task->id]);
            $this->assertDatabaseHas('audit_logs', [
                'admin_id' => $admin->id,
                'action' => 'task_deleted',
                'model_type' => 'Task',
                'model_id' => $task->id,
            ]);
        }
    }

    public function test_admin_settings_update_logged(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($superAdmin, 'sanctum')
            ->putJson('/api/v1/admin/settings', [
                'site_name' => 'New Site Name',
                'admin_email' => 'admin@example.com',
            ])
            ->assertOk();

        $this->assertDatabaseHas('audit_logs', [
            'admin_id' => $superAdmin->id,
            'action' => 'update',
            'model_type' => 'AdminSettings',
        ]);
    }

    public function test_last_super_admin_cannot_be_deleted(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($superAdmin, 'sanctum')
            ->deleteJson("/api/v1/admin/users/{$superAdmin->id}")
            ->assertForbidden()
            ->assertJsonPath('error.code', 'forbidden');
    }

    public function test_unauthenticated_user_cannot_access_admin(): void
    {
        $this->getJson('/api/v1/admin/users')
            ->assertUnauthorized();
    }

    public function test_super_admin_can_access_all_admin_features(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($superAdmin, 'sanctum')
            ->getJson('/api/v1/admin/users')
            ->assertOk();

        $this->actingAs($superAdmin, 'sanctum')
            ->getJson('/api/v1/admin/audit-logs')
            ->assertOk();

        $this->actingAs($superAdmin, 'sanctum')
            ->getJson('/api/v1/admin/settings')
            ->assertOk();
    }

    public function test_admin_can_view_all_tasks(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        Task::factory()->count(3)->create();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/tasks')
            ->assertOk()
            ->assertJsonStructure(['data', 'links', 'meta']);
    }

    public function test_moderator_can_moderate_tasks(): void
    {
        $moderator = $this->createUserWithRole(Role::MODERATOR);
        Task::factory()->count(2)->create();

        $this->actingAs($moderator, 'sanctum')
            ->getJson('/api/v1/admin/tasks')
            ->assertOk();

        $this->actingAs($moderator, 'sanctum')
            ->getJson('/api/v1/admin/users')
            ->assertForbidden();
    }

    public function test_admin_cannot_view_audit_logs(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/audit-logs')
            ->assertForbidden();
    }

    public function test_super_admin_can_update_settings(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($superAdmin, 'sanctum')
            ->putJson('/api/v1/admin/settings', [
                'site_name' => 'Updated Site',
                'admin_email' => 'admin@example.com',
            ])
            ->assertOk();
    }

    public function test_settings_update_logged(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($superAdmin, 'sanctum')
            ->putJson('/api/v1/admin/settings', [
                'site_name' => 'Test',
                'admin_email' => 'admin@example.com',
            ])
            ->assertOk();

        $this->assertDatabaseHas('audit_logs', [
            'admin_id' => $superAdmin->id,
            'action' => 'update',
            'model_type' => 'AdminSettings',
        ]);
    }

    public function test_suspension_reason_is_required_for_admin_action(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $target = User::factory()->create();

        $this->actingAs($admin, 'sanctum')
            ->postJson("/api/v1/admin/users/{$target->id}/suspend", [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['reason']);
    }

    public function test_admin_cannot_delete_last_super_admin(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);
        $admin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->deleteJson("/api/v1/admin/users/{$superAdmin->id}")
            ->assertForbidden();
    }

    public function test_user_management_api_returns_paginated_results(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        User::factory()->count(25)->create();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/users?per_page=10')
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_task_management_api_returns_paginated_results(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        Task::factory()->count(25)->create();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/tasks?per_page=10')
            ->assertOk()
            ->assertJsonStructure([
                'data',
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'last_page', 'per_page', 'total'],
            ])
            ->assertJsonCount(10, 'data');
    }

    public function test_admin_login_requires_admin_role(): void
    {
        $user = $this->createUserWithRole(Role::USER);

        $this->postJson('/api/v1/admin/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertForbidden();
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = $this->createUserWithRole(Role::USER);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/admin/users')
            ->assertForbidden();
    }

    public function test_admin_dashboard_loads_for_admin_users(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/analytics/dashboard')
            ->assertOk()
            ->assertJsonStructure(['users', 'tasks', 'activity']);
    }

    public function test_deleted_user_removes_related_role_assignments(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN);
        $user = User::factory()->create();
        $user->roles()->attach(Role::query()->where('name', Role::MODERATOR)->value('id'));

        $this->actingAs($superAdmin, 'sanctum')
            ->deleteJson("/api/v1/admin/users/{$user->id}")
            ->assertOk();

        $this->assertDatabaseMissing('role_user', ['user_id' => $user->id]);
    }

    public function test_admin_user_can_view_analytics_endpoints(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/analytics/dashboard')
            ->assertOk();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/analytics/users')
            ->assertOk();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/v1/admin/analytics/tasks')
            ->assertOk();
    }

    public function test_non_admin_cannot_view_analytics_endpoints(): void
    {
        $user = $this->createUserWithRole(Role::USER);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/v1/admin/analytics/dashboard')
            ->assertForbidden();
    }

    public function test_bulk_task_reassignment_updates_all_tasks(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $tasks = Task::factory()->count(5)->create();
        $newOwner = User::factory()->create();

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/admin/tasks/bulk-action', [
                'task_ids' => $tasks->pluck('id')->toArray(),
                'action' => 'reassign',
                'user_id' => $newOwner->id,
            ])
            ->assertOk()
            ->assertJsonPath('processed', 5);

        foreach ($tasks as $task) {
            $this->assertDatabaseHas('tasks', [
                'id' => $task->id,
                'user_id' => $newOwner->id,
            ]);
        }
    }

    public function test_reassign_task_validation_rejects_invalid_user(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $task = Task::factory()->create();

        $this->actingAs($admin, 'sanctum')
            ->putJson("/api/v1/admin/tasks/{$task->id}", [
                'user_id' => 99999,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['user_id']);
    }

    public function test_bulk_action_validation_rejects_empty_task_ids(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/admin/tasks/bulk-action', [
                'task_ids' => [],
                'action' => 'delete',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['task_ids']);
    }

    public function test_bulk_action_validation_rejects_too_many_tasks(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN);
        $taskIds = range(1, 101);

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/v1/admin/tasks/bulk-action', [
                'task_ids' => $taskIds,
                'action' => 'delete',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['task_ids']);
    }
}
