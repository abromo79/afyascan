<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_user_can_be_created(): void
    {
        $this->post(route('admin.users.store'), [
            'name' => 'New Editor',
            'email' => 'editor2@example.org',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
            'role' => User::ROLE_EDITOR,
            'is_active' => '1',
        ])->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'editor2@example.org',
            'role' => User::ROLE_EDITOR,
            'is_active' => true,
        ]);
    }

    public function test_password_is_hashed(): void
    {
        $this->post(route('admin.users.store'), [
            'name' => 'Hashed User',
            'email' => 'hashed@example.org',
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
            'role' => User::ROLE_EDITOR,
        ]);

        $user = User::where('email', 'hashed@example.org')->firstOrFail();

        $this->assertNotSame('secret-password', $user->password);
        $this->assertTrue(password_verify('secret-password', $user->password));
    }

    public function test_user_can_be_updated_without_changing_password(): void
    {
        $user = User::factory()->create();

        $this->put(route('admin.users.update', $user), [
            'name' => 'Renamed',
            'email' => $user->email,
            'role' => User::ROLE_EDITOR,
        ])->assertRedirect(route('admin.users.index'));

        $this->assertSame('Renamed', $user->fresh()->name);
    }

    public function test_user_password_can_be_reset(): void
    {
        $user = User::factory()->create();

        $this->put(route('admin.users.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'brand-new-password',
            'password_confirmation' => 'brand-new-password',
            'role' => $user->role,
        ])->assertRedirect(route('admin.users.index'));

        $this->assertTrue(password_verify('brand-new-password', $user->fresh()->password));
    }

    public function test_user_can_be_deactivated(): void
    {
        $user = User::factory()->create();

        $this->put(route('admin.users.update', $user), [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ])->assertRedirect(route('admin.users.index'));

        $this->assertFalse($user->fresh()->is_active);
    }

    public function test_deactivated_user_cannot_reach_admin(): void
    {
        $user = User::factory()->inactive()->create();

        $this->actingAs($user)->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
    }

    public function test_user_can_be_deleted(): void
    {
        $user = User::factory()->create();

        $this->delete(route('admin.users.destroy', $user))
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $this->delete(route('admin.users.destroy', $this->admin))->assertStatus(422);

        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_last_administrator_cannot_be_demoted_or_deactivated(): void
    {
        $this->put(route('admin.users.update', $this->admin), [
            'name' => $this->admin->name,
            'email' => $this->admin->email,
            'role' => User::ROLE_EDITOR,
        ])->assertStatus(422);

        $this->assertTrue($this->admin->fresh()->isAdmin());
    }

    public function test_email_must_be_unique(): void
    {
        $existing = User::factory()->create();

        $this->post(route('admin.users.store'), [
            'name' => 'Duplicate',
            'email' => $existing->email,
            'password' => 'secret-password',
            'password_confirmation' => 'secret-password',
            'role' => User::ROLE_EDITOR,
        ])->assertSessionHasErrors('email');
    }
}
