<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::seedDefaults();
    }

    public function test_non_admin_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create();
        $user->roles()->sync([Role::query()->where('name', Role::USER)->value('id')]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $user = User::factory()->create();
        $user->roles()->sync([Role::query()->where('name', Role::ADMIN)->value('id')]);

        $this->actingAs($user)
            ->get('/admin/dashboard')
            ->assertStatus(200);
    }
}
