<?php

namespace Tests\Feature\Admin;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_team_member_can_be_created(): void
    {
        $this->post(route('admin.team.store'), [
            'name' => 'Amina Said',
            'position' => 'CEO & Founder',
            'bio' => 'Leading AfyaScan product and research direction.',
            'email' => 'amina@example.org',
            'linkedin' => 'https://linkedin.com/in/example',
            'display_order' => 1,
            'is_active' => '1',
        ])->assertRedirect(route('admin.team.index'));

        $this->assertDatabaseHas('team_members', [
            'name' => 'Amina Said',
            'position' => 'CEO & Founder',
            'is_active' => true,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Amina Said')
            ->assertSee('CEO &amp; Founder', escape: false);
    }

    public function test_team_member_can_be_updated(): void
    {
        $member = TeamMember::factory()->create(['name' => 'Old Name']);

        $this->put(route('admin.team.update', $member), [
            'name' => 'New Name',
            'position' => 'Co-Founder',
        ])->assertRedirect(route('admin.team.index'));

        $this->assertDatabaseHas('team_members', [
            'id' => $member->id,
            'name' => 'New Name',
            'position' => 'Co-Founder',
            'is_active' => false,
        ]);
    }

    public function test_team_member_can_be_deactivated(): void
    {
        $member = TeamMember::factory()->create(['is_active' => true]);

        $this->patch(route('admin.team.publish', $member));

        $this->assertFalse($member->fresh()->is_active);
        $this->get(route('home'))->assertDontSee($member->name);
    }

    public function test_team_member_can_be_deleted(): void
    {
        $member = TeamMember::factory()->create();

        $this->delete(route('admin.team.destroy', $member))
            ->assertRedirect(route('admin.team.index'));

        $this->assertDatabaseMissing('team_members', ['id' => $member->id]);
    }

    public function test_team_member_requires_name_and_position(): void
    {
        $this->post(route('admin.team.store'), [])->assertSessionHasErrors(['name', 'position']);

        $this->assertDatabaseCount('team_members', 0);
    }
}
