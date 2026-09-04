<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_the_public_landing_page(): void
    {
        $this->get(route('guest'))
            ->assertOk()
            ->assertSee('Tasks')
            ->assertSee(route('login'));
    }

    public function test_authenticated_user_can_access_task_pages(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create(['title' => 'Review release plan']);

        $this->actingAs($user)
            ->get(route('tasks.index'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('tasks.create'))
            ->assertOk();

        $this->actingAs($user)
            ->get(route('tasks.show', $task))
            ->assertOk()
            ->assertSee($task->title);

        $this->actingAs($user)
            ->get(route('tasks.edit', $task))
            ->assertOk();
    }

    public function test_user_cannot_view_another_users_task_pages(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->actingAs($user)->get(route('tasks.show', $task))->assertForbidden();
        $this->actingAs($user)->get(route('tasks.edit', $task))->assertForbidden();
    }

    public function test_guest_is_redirected_to_login_from_task_pages(): void
    {
        $task = Task::factory()->create();

        $this->get(route('tasks.index'))->assertRedirect(route('guest'));
        $this->get(route('tasks.create'))->assertRedirect(route('guest'));
        $this->get(route('tasks.show', $task))->assertRedirect(route('guest'));
        $this->get(route('tasks.edit', $task))->assertRedirect(route('guest'));
    }

    public function test_public_navigation_changes_with_authentication_state(): void
    {
        $this->get(route('about'))
            ->assertOk()
            ->assertSee(route('login'))
            ->assertSee(route('register'));

        $this->actingAs(User::factory()->create())
            ->get(route('about'))
            ->assertOk()
            ->assertSee(route('dashboard'))
            ->assertSee(route('profile.edit'))
            ->assertDontSee('>Sign in<');
    }
}
