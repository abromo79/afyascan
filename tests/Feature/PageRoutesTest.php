<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Partner;
use App\Models\Product;
use App\Models\TeamMember;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_are_accessible(): void
    {
        $this->get(route('home'))->assertOk();
        $this->get(route('about'))->assertOk();
        $this->get(route('products'))->assertOk();
        $this->get(route('products.risk-assessment'))->assertOk();
        $this->get(route('products.image-analysis'))->assertOk();
        $this->get(route('partners'))->assertOk();
        $this->get(route('blog'))->assertOk();
        $this->get(route('contact'))->assertOk();
    }

    public function test_blog_listing_uses_bootstrap_pagination(): void
    {
        BlogPost::factory()->count(5)->create([
            'status' => BlogPost::STATUS_PUBLISHED,
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('blog'))
            ->assertOk()
            ->assertSee('pagination', false)
            ->assertSee('page-link', false)
            ->assertSee('rel="next"', false)
            ->assertDontSee('relative inline-flex', false);

        $this->get(route('blog', ['page' => 2]))
            ->assertOk()
            ->assertSee('pagination', false);
    }

    public function test_blog_post_page_is_accessible(): void
    {
        $post = BlogPost::published()->firstOrFail();

        $this->get(route('blog.show', $post->slug))
            ->assertOk()
            ->assertSee($post->title);
    }

    public function test_draft_and_unknown_blog_posts_are_not_public(): void
    {
        $draft = BlogPost::factory()->draft()->create();

        $this->get(route('blog.show', $draft->slug))->assertNotFound();
        $this->get(route('blog.show', 'no-such-post'))->assertNotFound();
    }

    public function test_products_page_shows_published_products_only(): void
    {
        Product::factory()->create(['name' => 'Visible Product']);
        Product::factory()->unpublished()->create(['name' => 'Hidden Product']);

        $this->get(route('products'))
            ->assertOk()
            ->assertSee('Visible Product')
            ->assertDontSee('Hidden Product');
    }

    public function test_partners_page_shows_active_partners_only(): void
    {
        Partner::factory()->create(['name' => 'Active Partner']);
        Partner::factory()->inactive()->create(['name' => 'Inactive Partner']);

        $this->get(route('partners'))
            ->assertOk()
            ->assertSee('Active Partner')
            ->assertDontSee('Inactive Partner');
    }

    public function test_home_page_shows_active_team_members_only(): void
    {
        TeamMember::factory()->create(['name' => 'Active Member']);
        TeamMember::factory()->inactive()->create(['name' => 'Inactive Member']);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Active Member')
            ->assertDontSee('Inactive Member');
    }

    public function test_pages_render_when_no_partners_or_team_members_exist(): void
    {
        $this->assertSame(0, Partner::count());
        $this->assertSame(0, TeamMember::count());

        $this->get(route('partners'))->assertOk();
        $this->get(route('home'))->assertOk();
        $this->get(route('about'))->assertOk();
    }

    public function test_contact_form_stores_a_message(): void
    {
        $payload = [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.org',
            'organization' => 'Example Org',
            'subject' => 'Partnership enquiry',
            'message' => 'We would like to discuss a research collaboration.',
        ];

        $this->post(route('contact.store'), $payload)
            ->assertRedirect(route('contact'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Jane Visitor',
            'email' => 'jane@example.org',
            'subject' => 'Partnership enquiry',
            'is_read' => false,
        ]);
    }

    public function test_contact_form_rejects_invalid_input(): void
    {
        $this->post(route('contact.store'), ['name' => '', 'email' => 'nope', 'message' => 'short'])
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
