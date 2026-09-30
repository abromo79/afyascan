<?php

namespace Tests\Feature\Admin;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MessageManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_messages_are_listed(): void
    {
        ContactMessage::factory()->create(['subject' => 'Partnership enquiry']);

        $this->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Partnership enquiry');
    }

    public function test_opening_a_message_marks_it_as_read(): void
    {
        $message = ContactMessage::factory()->create(['is_read' => false]);

        $this->get(route('admin.messages.show', $message))->assertOk();

        $this->assertTrue($message->fresh()->is_read);
    }

    public function test_message_can_be_marked_as_replied(): void
    {
        $message = ContactMessage::factory()->create();

        $this->patch(route('admin.messages.update', $message), [
            'is_read' => '1',
            'is_replied' => '1',
        ])->assertSessionHas('success');

        $this->assertTrue($message->fresh()->is_replied);
    }

    public function test_message_can_be_archived_and_restored(): void
    {
        $message = ContactMessage::factory()->create(['subject' => 'Archive me']);

        $this->patch(route('admin.messages.update', $message), ['is_archived' => '1']);

        $this->assertTrue($message->fresh()->is_archived);
        $this->get(route('admin.messages.index', ['filter' => 'active']))->assertDontSee('Archive me');
        $this->get(route('admin.messages.index', ['filter' => 'archived']))->assertSee('Archive me');

        $this->patch(route('admin.messages.update', $message), ['is_archived' => '0']);

        $this->assertFalse($message->fresh()->is_archived);
    }

    public function test_message_can_be_deleted(): void
    {
        $message = ContactMessage::factory()->create();

        $this->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_unread_filter_shows_only_unread_messages(): void
    {
        $unread = ContactMessage::factory()->create(['subject' => 'Fresh enquiry']);
        ContactMessage::factory()->read()->create(['subject' => 'Old enquiry']);

        $this->get(route('admin.messages.index', ['filter' => 'unread']))
            ->assertOk()
            ->assertSee('Fresh enquiry')
            ->assertDontSee('Old enquiry');
    }
}
