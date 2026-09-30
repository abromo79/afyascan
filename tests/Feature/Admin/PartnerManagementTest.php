<?php

namespace Tests\Feature\Admin;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartnerManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_partner_can_be_created(): void
    {
        $this->post(route('admin.partners.store'), [
            'name' => 'Zanzibar Health Institute',
            'website' => 'https://example.org',
            'description' => 'A research partner supporting breast health studies.',
            'partnership_type' => 'Healthcare & Research',
            'display_order' => 1,
            'is_active' => '1',
        ])->assertRedirect(route('admin.partners.index'));

        $this->assertDatabaseHas('partners', [
            'name' => 'Zanzibar Health Institute',
            'partnership_type' => 'Healthcare & Research',
            'is_active' => true,
        ]);

        $this->get(route('partners'))
            ->assertOk()
            ->assertSee('Zanzibar Health Institute')
            ->assertSee('A research partner supporting breast health studies.');
    }

    public function test_partner_can_be_updated(): void
    {
        $partner = Partner::factory()->create(['name' => 'Old Partner']);

        $this->put(route('admin.partners.update', $partner), [
            'name' => 'Updated Partner',
            'is_active' => '1',
        ])->assertRedirect(route('admin.partners.index'));

        $this->assertDatabaseHas('partners', [
            'id' => $partner->id,
            'name' => 'Updated Partner',
            'is_active' => true,
        ]);
    }

    public function test_partner_can_be_activated_and_deactivated(): void
    {
        $partner = Partner::factory()->create(['is_active' => true]);

        $this->patch(route('admin.partners.publish', $partner));
        $this->assertFalse($partner->fresh()->is_active);
        $this->get(route('partners'))->assertDontSee($partner->name);

        $this->patch(route('admin.partners.publish', $partner));
        $this->assertTrue($partner->fresh()->is_active);
    }

    public function test_partner_can_be_deleted(): void
    {
        $partner = Partner::factory()->create();

        $this->delete(route('admin.partners.destroy', $partner))
            ->assertRedirect(route('admin.partners.index'));

        $this->assertDatabaseMissing('partners', ['id' => $partner->id]);
    }

    public function test_partner_requires_a_name(): void
    {
        $this->post(route('admin.partners.store'), [])->assertSessionHasErrors('name');

        $this->assertDatabaseCount('partners', 0);
    }
}
