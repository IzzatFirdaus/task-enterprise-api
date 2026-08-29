<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_list_only_their_tasks(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        Task::factory()->create(['user_id' => $user->id, 'title' => 'Visible task']);
        Task::factory()->create(['user_id' => $otherUser->id, 'title' => 'Private task']);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/tasks');

        $response->assertOk()->assertJsonFragment(['title' => 'Visible task'])->assertJsonMissing(['title' => 'Private task']);
    }

    public function test_authenticated_user_can_create_a_task(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/tasks', [
            'title' => 'Ship API documentation',
            'description' => 'Publish endpoint examples.',
            'status' => 'pending',
        ]);

        $response->assertCreated()->assertJsonPath('title', 'Ship API documentation');
        $this->assertDatabaseHas('tasks', ['title' => 'Ship API documentation', 'user_id' => $user->id]);
    }

    public function test_authenticated_user_can_update_their_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->putJson("/api/tasks/{$task->id}", [
            'title' => 'Updated title',
            'status' => 'completed',
        ]);

        $response->assertOk()->assertJsonPath('title', 'Updated title');
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'completed']);
    }

    public function test_authenticated_user_cannot_update_another_users_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => User::factory()->create()->id]);

        $this->actingAs($user, 'sanctum')
            ->putJson("/api/tasks/{$task->id}", ['title' => 'Unauthorized change'])
            ->assertForbidden();
    }

    public function test_authenticated_user_can_delete_their_task(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'sanctum')->deleteJson("/api/tasks/{$task->id}")->assertNoContent();
        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_unauthenticated_users_cannot_access_task_endpoints(): void
    {
        $task = Task::factory()->create();
        $payload = ['title' => 'Unauthorized task'];

        $this->getJson('/api/tasks')->assertUnauthorized();
        $this->postJson('/api/tasks', $payload)->assertUnauthorized();
        $this->getJson("/api/tasks/{$task->id}")->assertUnauthorized();
        $this->putJson("/api/tasks/{$task->id}", $payload)->assertUnauthorized();
        $this->deleteJson("/api/tasks/{$task->id}")->assertUnauthorized();
    }
}
