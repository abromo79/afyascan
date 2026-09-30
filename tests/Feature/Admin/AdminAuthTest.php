<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_public(): void
    {
        $this->get(route('admin.login'))->assertOk()->assertSee('AfyaScan Admin');
    }

    public function test_admin_can_sign_in(): void
    {
        $user = User::factory()->admin()->create();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_sign_in_fails_with_wrong_credentials(): void
    {
        $user = User::factory()->admin()->create();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_inactive_user_cannot_sign_in(): void
    {
        $user = User::factory()->admin()->inactive()->create();

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_user_without_admin_role_cannot_sign_in(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_EDITOR]);

        $this->actingAs($user)->post(route('admin.logout'));

        $user->update(['role' => 'VIEWER']);

        $this->post(route('admin.login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.products.index'))->assertRedirect(route('admin.login'));
    }

    public function test_user_can_log_out(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)->post(route('admin.logout'))->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }
}
