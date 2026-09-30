<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_reach_every_admin_page(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin);

        foreach ([
            route('admin.dashboard'),
            route('admin.products.index'),
            route('admin.partners.index'),
            route('admin.team.index'),
            route('admin.posts.index'),
            route('admin.post-categories.index'),
            route('admin.messages.index'),
            route('admin.users.index'),
            route('admin.settings.edit'),
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_editor_can_reach_editor_pages(): void
    {
        $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);

        $this->actingAs($editor);

        $this->get(route('admin.dashboard'))->assertOk();
        $this->get(route('admin.products.index'))->assertOk();
        $this->get(route('admin.partners.index'))->assertOk();
        $this->get(route('admin.team.index'))->assertOk();
        $this->get(route('admin.posts.index'))->assertOk();
        $this->get(route('admin.messages.index'))->assertOk();
    }

    public function test_editor_cannot_reach_admin_only_pages(): void
    {
        $editor = User::factory()->create(['role' => User::ROLE_EDITOR]);

        $this->actingAs($editor);

        $this->get(route('admin.users.index'))->assertForbidden();
        $this->get(route('admin.settings.edit'))->assertForbidden();
        $this->get(route('admin.users.create'))->assertForbidden();
    }

    public function test_inactive_user_is_logged_out(): void
    {
        $user = User::factory()->admin()->inactive()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}
