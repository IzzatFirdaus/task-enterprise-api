<?php

namespace Tests\Feature\Admin;

use App\Models\AuditLog;
use App\Models\Role;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminSystemTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::seedDefaults();
    }

    private function createUserWithRole(string $roleName, array $attributes = []): User
    {
        $user = User::factory()->create(array_merge([
            'name' => 'Test User',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
        ], $attributes));

        $roleId = Role::query()->where('name', $roleName)->value('id');

        $user->roles()->syncWithoutDetaching([
            $roleId => [
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        return $user->fresh(['roles']);
    }

    private function createTaskFor(User $user, array $attributes = []): Task
    {
        return Task::factory()->create(array_merge([
            'user_id' => $user->getKey(),
            'title' => 'Task title',
            'description' => 'Task description',
            'status' => 'pending',
        ], $attributes));
    }

    private function assignRoleToUser(User $user, string $roleName): void
    {
        $roleId = Role::query()->where('name', $roleName)->value('id');

        $user->roles()->syncWithoutDetaching([
            $roleId => [
                'assigned_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    // ---------------------------------------------------------------------
    // Group 1: RBAC & Gate Protection (10 cases)
    // ---------------------------------------------------------------------

    public function test_super_admin_can_access_admin_dashboard(): void
    {
        $user = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $user = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertOk();
    }

    public function test_moderator_can_access_task_moderation_routes(): void
    {
        $user = $this->createUserWithRole(Role::MODERATOR);

        $this->actingAs($user)
            ->get('/admin/tasks')
            ->assertOk();
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = $this->createUserWithRole(Role::USER);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_unauthenticated_user_cannot_access_admin_dashboard(): void
    {
        $this->get('/admin/dashboard')
            ->assertRedirect('/admin/login');
    }

    public function test_super_admin_can_access_user_management_index(): void
    {
        $user = $this->createUserWithRole(Role::SUPER_ADMIN);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertOk();
    }

    public function test_admin_can_access_user_management_index(): void
    {
        $user = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertOk();
    }

    public function test_moderator_is_forbidden_from_user_management_index(): void
    {
        $user = $this->createUserWithRole(Role::MODERATOR);

        $this->actingAs($user)
            ->get('/admin/users')
            ->assertForbidden();
    }

    public function test_user_is_forbidden_from_audit_log_index(): void
    {
        $user = $this->createUserWithRole(Role::USER);

        $this->actingAs($user)
            ->get('/admin/audit-logs')
            ->assertForbidden();
    }

    public function test_admin_is_forbidden_from_audit_log_index(): void
    {
        $user = $this->createUserWithRole(Role::ADMIN);

        $this->actingAs($user)
            ->get('/admin/audit-logs')
            ->assertForbidden();
    }

    // ---------------------------------------------------------------------
    // Group 2: Super Admin Guardrails (5 cases)
    // ---------------------------------------------------------------------

    public function test_last_super_admin_cannot_be_deleted(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'sole-super@example.com']);

        $this->actingAs($superAdmin)
            ->delete('/admin/users/'.$superAdmin->getKey())
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $superAdmin->getKey()]);
    }

    public function test_super_admin_cannot_self_suspend(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'guardian@example.com']);

        $this->actingAs($superAdmin)
            ->post('/admin/users/'.$superAdmin->getKey().'/suspend', [
                'reason' => 'Self-suspension attempt',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('users', [
            'id' => $superAdmin->getKey(),
            'is_suspended' => false,
        ]);
    }

    public function test_super_admin_cannot_be_demoted_when_he_is_the_sole_super_admin(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'sole-super-admin@example.com']);

        $this->actingAs($superAdmin)
            ->put('/admin/users/'.$superAdmin->getKey(), [
                'name' => $superAdmin->name,
                'email' => $superAdmin->email,
                'roles' => [],
            ])
            ->assertForbidden();

        $this->assertTrue($superAdmin->fresh()->isSuperAdmin());
    }

    public function test_non_super_admin_cannot_assign_super_admin_role(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-assigner@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'user-target@example.com']);

        $this->actingAs($admin)
            ->post('/api/admin/users/'.$target->getKey().'/roles/'.Role::SUPER_ADMIN, [])
            ->assertForbidden();

        $this->assertFalse($target->fresh()->isSuperAdmin());
    }

    public function test_super_admin_guardrail_requires_a_second_super_admin_before_role_removal(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'super-admin-a@example.com']);
        $secondSuperAdmin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'super-admin-b@example.com']);

        $this->actingAs($superAdmin)
            ->delete('/admin/users/'.$secondSuperAdmin->getKey().'/role/'.Role::SUPER_ADMIN)
            ->assertForbidden();

        $this->assertTrue($secondSuperAdmin->fresh()->isSuperAdmin());
    }

    // ---------------------------------------------------------------------
    // Group 3: User & Task Moderation (10 cases)
    // ---------------------------------------------------------------------

    public function test_admin_can_suspend_user_with_reason(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-suspend@example.com']);
        $user = $this->createUserWithRole(Role::USER, ['email' => 'target-user@example.com']);

        $this->actingAs($admin)
            ->post('/admin/users/'.$user->getKey().'/suspend', [
                'reason' => 'Policy violation',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'is_suspended' => true,
        ]);
        $this->assertNotNull($user->fresh()->suspended_at);
        $this->assertSame('Policy violation', $user->fresh()->suspension_reason);
    }

    public function test_admin_can_unsuspend_user(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-unsuspend@example.com']);
        $user = $this->createUserWithRole(Role::USER, [
            'email' => 'unsuspend-target@example.com',
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => 'Temporary lock',
        ]);

        $this->actingAs($admin)
            ->post('/admin/users/'.$user->getKey().'/unsuspend', [])
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->getKey(),
            'is_suspended' => false,
        ]);
    }

    public function test_suspended_user_cannot_access_admin_dashboard(): void
    {
        $user = $this->createUserWithRole(Role::ADMIN, [
            'email' => 'suspended-admin@example.com',
            'is_suspended' => true,
            'suspended_at' => now(),
            'suspension_reason' => 'Account locked',
        ]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertForbidden();
    }

    public function test_moderator_can_soft_delete_task(): void
    {
        $moderator = $this->createUserWithRole(Role::MODERATOR, ['email' => 'moderator-delete@example.com']);
        $owner = $this->createUserWithRole(Role::USER, ['email' => 'task-owner@example.com']);
        $task = $this->createTaskFor($owner, ['title' => 'Delete me']);

        $this->actingAs($moderator)
            ->delete('/admin/tasks/'.$task->getKey())
            ->assertRedirect();

        $this->assertSoftDeleted('tasks', ['id' => $task->getKey()]);
    }

    public function test_moderator_can_restore_soft_deleted_task(): void
    {
        $moderator = $this->createUserWithRole(Role::MODERATOR, ['email' => 'moderator-restore@example.com']);
        $owner = $this->createUserWithRole(Role::USER, ['email' => 'restore-owner@example.com']);
        $task = $this->createTaskFor($owner, ['title' => 'Restore me', 'deleted_at' => now()]);

        $this->actingAs($moderator)
            ->patch('/admin/tasks/'.$task->getKey().'/restore')
            ->assertRedirect();

        $this->assertDatabaseHas('tasks', ['id' => $task->getKey(), 'deleted_at' => null]);
    }

    public function test_moderator_can_change_task_status(): void
    {
        $moderator = $this->createUserWithRole(Role::MODERATOR, ['email' => 'moderator-status@example.com']);
        $owner = $this->createUserWithRole(Role::USER, ['email' => 'status-owner@example.com']);
        $task = $this->createTaskFor($owner, ['status' => 'pending']);

        $this->actingAs($moderator)
            ->put('/admin/tasks/'.$task->getKey().'/status', [
                'status' => 'completed',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->getKey(),
            'status' => 'completed',
        ]);
    }

    public function test_admin_can_reassign_task_to_another_user(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-reassign@example.com']);
        $owner = $this->createUserWithRole(Role::USER, ['email' => 'owner-a@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'owner-b@example.com']);
        $task = $this->createTaskFor($owner, ['title' => 'Reassign task']);

        $this->actingAs($admin)
            ->put('/admin/tasks/'.$task->getKey().'/reassign', [
                'user_id' => $target->getKey(),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'id' => $task->getKey(),
            'user_id' => $target->getKey(),
        ]);
    }

    public function test_admin_can_bulk_reassign_tasks(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-bulk-reassign@example.com']);
        $owner = $this->createUserWithRole(Role::USER, ['email' => 'bulk-owner@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'bulk-target@example.com']);
        $taskOne = $this->createTaskFor($owner, ['title' => 'Bulk task 1']);
        $taskTwo = $this->createTaskFor($owner, ['title' => 'Bulk task 2']);

        $this->actingAs($admin)
            ->post('/admin/tasks/bulk-action', [
                'task_ids' => [$taskOne->getKey(), $taskTwo->getKey()],
                'action' => 'reassign',
                'user_id' => $target->getKey(),
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('tasks', ['id' => $taskOne->getKey(), 'user_id' => $target->getKey()]);
        $this->assertDatabaseHas('tasks', ['id' => $taskTwo->getKey(), 'user_id' => $target->getKey()]);
    }

    public function test_admin_can_bulk_delete_tasks(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-bulk-delete@example.com']);
        $owner = $this->createUserWithRole(Role::USER, ['email' => 'bulk-delete-owner@example.com']);
        $taskOne = $this->createTaskFor($owner, ['title' => 'Bulk delete 1']);
        $taskTwo = $this->createTaskFor($owner, ['title' => 'Bulk delete 2']);

        $this->actingAs($admin)
            ->post('/admin/tasks/bulk-action', [
                'task_ids' => [$taskOne->getKey(), $taskTwo->getKey()],
                'action' => 'delete',
            ])
            ->assertRedirect();

        $this->assertSoftDeleted('tasks', ['id' => $taskOne->getKey()]);
        $this->assertSoftDeleted('tasks', ['id' => $taskTwo->getKey()]);
    }

    public function test_user_cannot_moderate_another_users_task(): void
    {
        $user = $this->createUserWithRole(Role::USER, ['email' => 'user-a@example.com']);
        $other = $this->createUserWithRole(Role::USER, ['email' => 'user-b@example.com']);
        $task = $this->createTaskFor($other, ['title' => 'Other user task']);

        $this->actingAs($user)
            ->put('/admin/tasks/'.$task->getKey().'/status', ['status' => 'completed'])
            ->assertForbidden();
    }

    // ---------------------------------------------------------------------
    // Group 4: Audit Logging & Data Export (10 cases)
    // ---------------------------------------------------------------------

    public function test_audit_log_records_user_update_payload_with_exact_fields(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'audit-update-admin@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'audit-update-target@example.com']);

        $this->actingAs($admin)
            ->put('/admin/users/'.$target->getKey(), [
                'name' => 'Updated Name',
                'email' => 'updated-email@example.com',
                'roles' => [Role::query()->where('name', Role::USER)->value('id')],
            ]);

        $log = AuditLog::query()->where('model_type', 'User')->where('model_id', $target->getKey())->latest('created_at')->first();

        $this->assertNotNull($log);
        $this->assertSame($admin->getKey(), $log->admin_id);
        $this->assertSame('user_updated', $log->action);
        $this->assertSame('User', $log->model_type);
        $this->assertIsArray($log->changes);
        $this->assertArrayHasKey('before', $log->changes);
        $this->assertArrayHasKey('after', $log->changes);
        $this->assertSame('Updated Name', $log->changes['after']['name']);
    }

    public function test_audit_log_records_suspension_action_with_reason_and_ip(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'audit-suspend-admin@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'audit-suspend-target@example.com']);

        $this->actingAs($admin)
            ->withServerVariables(['REMOTE_ADDR' => '127.0.0.1'])
            ->post('/admin/users/'.$target->getKey().'/suspend', [
                'reason' => 'Suspended for policy review',
            ]);

        $log = AuditLog::query()->where('action', 'user_suspended')->latest('created_at')->first();

        $this->assertNotNull($log);
        $this->assertSame($admin->getKey(), $log->admin_id);
        $this->assertSame('user_suspended', $log->action);
        $this->assertSame('127.0.0.1', $log->ip_address);
        $this->assertArrayHasKey('reason', $log->changes['after'] ?? []);
    }

    public function test_audit_log_records_role_assignment_payload(): void
    {
        $admin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'audit-role-admin@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'audit-role-target@example.com']);

        $this->actingAs($admin)
            ->post('/api/admin/users/'.$target->getKey().'/roles/'.Role::ADMIN, []);

        $log = AuditLog::query()->where('action', 'role_assigned')->latest('created_at')->first();

        $this->assertNotNull($log);
        $this->assertSame($admin->getKey(), $log->admin_id);
        $this->assertSame('role_assigned', $log->action);
        $this->assertSame('User', $log->model_type);
        $this->assertSame($target->getKey(), $log->model_id);
        $this->assertSame(Role::ADMIN, $log->changes['after']['role_name'] ?? null);
    }

    public function test_audit_log_export_returns_csv_stream_for_super_admin(): void
    {
        $admin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'audit-export-admin@example.com']);
        $this->createUserWithRole(Role::USER, ['email' => 'export-target@example.com']);

        AuditLog::query()->create([
            'admin_id' => $admin->getKey(),
            'action' => 'user_created',
            'model_type' => 'User',
            'model_id' => $admin->getKey(),
            'changes' => ['before' => null, 'after' => ['name' => 'Audit export']],
            'ip_address' => '127.0.0.1',
            'user_agent' => 'phpunit',
            'created_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get('/admin/audit-logs/export')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->assertHeader('Content-Disposition');
    }

    public function test_audit_log_export_contains_expected_csv_headers(): void
    {
        $superAdmin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'csv-headers-admin@example.com']);

        $this->actingAs($superAdmin)
            ->get('/admin/audit-logs/export')
            ->assertOk()
            ->assertSeeText('admin_id')
            ->assertSeeText('action')
            ->assertSeeText('model_type')
            ->assertSeeText('changes');
    }

    public function test_non_super_admin_cannot_export_audit_logs(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'audit-export-blocked@example.com']);

        $this->actingAs($admin)
            ->get('/admin/audit-logs/export')
            ->assertForbidden();
    }

    public function test_logging_failure_rolls_back_transaction_when_audit_record_cannot_be_written(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'rollback-admin@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'rollback-target@example.com']);

        $this->expectException(\Throwable::class);

        DB::transaction(function () use ($admin, $target) {
            $this->actingAs($admin)
                ->put('/admin/users/'.$target->getKey(), [
                    'name' => 'Rollback Check',
                    'email' => 'rollback-check@example.com',
                    'roles' => [Role::query()->where('name', Role::USER)->value('id')],
                ]);

            throw new \RuntimeException('Audit log write failed.');
        });
    }

    public function test_failed_login_attempt_creates_audit_log_record(): void
    {
        $user = $this->createUserWithRole(Role::ADMIN, ['email' => 'failed-login-user@example.com']);

        $this->from('/admin/login')
            ->post('/admin/login', [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])
            ->assertSessionHasErrors('email');

        $this->assertDatabaseHas('audit_logs', [
            'action' => 'login_failed',
            'model_type' => 'AdminLogin',
        ]);
    }

    public function test_user_update_audit_log_uses_exact_model_type_value(): void
    {
        $admin = $this->createUserWithRole(Role::SUPER_ADMIN, ['email' => 'model-type-admin@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'model-type-target@example.com']);

        $this->actingAs($admin)
            ->put('/admin/users/'.$target->getKey(), [
                'name' => 'Model Type Name',
                'email' => 'model-type-email@example.com',
                'roles' => [Role::query()->where('name', Role::USER)->value('id')],
            ]);

        $log = AuditLog::query()->where('model_id', $target->getKey())->latest('created_at')->first();

        $this->assertSame('User', $log->model_type);
    }

    public function test_admin_id_is_recorded_exactly_on_user_modification(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'admin-id-audit@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'admin-id-target@example.com']);

        $this->actingAs($admin)
            ->put('/admin/users/'.$target->getKey(), [
                'name' => 'Admin ID Audit Name',
                'email' => 'admin-id-audit-target@example.com',
                'roles' => [Role::query()->where('name', Role::USER)->value('id')],
            ]);

        $log = AuditLog::query()->where('model_type', 'User')->latest('created_at')->first();

        $this->assertSame($admin->getKey(), $log->admin_id);
    }

    public function test_audit_log_changes_payload_contains_before_and_after_arrays(): void
    {
        $admin = $this->createUserWithRole(Role::ADMIN, ['email' => 'changes-array-admin@example.com']);
        $target = $this->createUserWithRole(Role::USER, ['email' => 'changes-array-target@example.com']);

        $this->actingAs($admin)
            ->put('/admin/users/'.$target->getKey(), [
                'name' => 'Changes Array Name',
                'email' => 'changes-array-email@example.com',
                'roles' => [Role::query()->where('name', Role::USER)->value('id')],
            ]);

        $log = AuditLog::query()->where('action', 'user_updated')->latest('created_at')->first();

        $this->assertArrayHasKey('before', $log->changes);
        $this->assertArrayHasKey('after', $log->changes);
        $this->assertIsArray($log->changes['before']);
        $this->assertIsArray($log->changes['after']);
    }
}
