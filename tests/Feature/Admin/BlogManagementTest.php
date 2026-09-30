<?php

namespace Tests\Feature\Admin;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
        $this->actingAs($this->admin);
    }

    public function test_post_can_be_created_as_a_draft(): void
    {
        $category = BlogCategory::factory()->create();

        $this->post(route('admin.posts.store'), [
            'title' => 'A New Draft',
            'excerpt' => 'Short summary.',
            'content' => '<p>Body copy.</p>',
            'blog_category_id' => $category->id,
            'status' => 'draft',
        ])->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A New Draft',
            'slug' => 'a-new-draft',
            'status' => BlogPost::STATUS_DRAFT,
            'blog_category_id' => $category->id,
        ]);

        $this->get(route('blog'))->assertOk()->assertDontSee('A New Draft');
    }

    public function test_published_post_appears_on_the_public_blog(): void
    {
        $category = BlogCategory::factory()->create(['name' => 'Breast Health']);

        $this->post(route('admin.posts.store'), [
            'title' => 'Understanding Early Detection',
            'excerpt' => 'A short summary for the listing page.',
            'content' => '<p>Full article body.</p>',
            'blog_category_id' => $category->id,
            'status' => 'published',
        ])->assertRedirect(route('admin.posts.index'));

        $this->get(route('blog'))
            ->assertOk()
            ->assertSee('Understanding Early Detection')
            ->assertSee('A short summary for the listing page.')
            ->assertSee('Breast Health');

        $this->get(route('blog.show', 'understanding-early-detection'))
            ->assertOk()
            ->assertSee('Full article body.', escape: false);
    }

    public function test_post_with_future_publication_date_is_not_public(): void
    {
        $post = BlogPost::factory()->scheduled()->create(['title' => 'Future Post']);

        $this->get(route('blog.show', $post->slug))->assertNotFound();
        $this->get(route('blog'))->assertDontSee('Future Post');
    }

    public function test_post_can_be_toggled_between_published_and_draft(): void
    {
        $post = BlogPost::factory()->create();

        $this->patch(route('admin.posts.publish', $post));
        $this->assertSame(BlogPost::STATUS_DRAFT, $post->fresh()->status);

        $this->patch(route('admin.posts.publish', $post));
        $this->assertSame(BlogPost::STATUS_PUBLISHED, $post->fresh()->status);
    }

    public function test_post_can_be_updated_and_deleted(): void
    {
        $post = BlogPost::factory()->create();

        $this->put(route('admin.posts.update', $post), [
            'title' => 'Renamed Post',
            'status' => 'published',
        ])->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'title' => 'Renamed Post']);

        $this->delete(route('admin.posts.destroy', $post))
            ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseMissing('blog_posts', ['id' => $post->id]);
    }

    public function test_duplicate_titles_get_unique_slugs(): void
    {
        BlogPost::factory()->create(['title' => 'Same Title', 'slug' => 'same-title']);

        $this->post(route('admin.posts.store'), [
            'title' => 'Same Title',
            'status' => 'draft',
        ])->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('blog_posts', ['slug' => 'same-title-2']);
    }

    public function test_post_requires_a_title(): void
    {
        $this->post(route('admin.posts.store'), [])->assertSessionHasErrors('title');

        $this->assertDatabaseCount('blog_posts', 0);
    }

    public function test_category_can_be_created_updated_and_deleted(): void
    {
        $this->post(route('admin.post-categories.store'), ['name' => 'Digital Health'])
            ->assertRedirect(route('admin.post-categories.index'));

        $this->assertDatabaseHas('blog_categories', ['name' => 'Digital Health', 'slug' => 'digital-health']);

        $category = BlogCategory::firstOrFail();

        $this->put(route('admin.post-categories.update', $category), ['name' => 'Digital Health & AI'])
            ->assertRedirect(route('admin.post-categories.index'));

        $this->assertDatabaseHas('blog_categories', ['id' => $category->id, 'name' => 'Digital Health & AI']);

        $this->delete(route('admin.post-categories.destroy', $category))
            ->assertRedirect(route('admin.post-categories.index'));

        $this->assertDatabaseMissing('blog_categories', ['id' => $category->id]);
    }

    public function test_deleting_a_category_leaves_its_posts_uncategorised(): void
    {
        $category = BlogCategory::factory()->create();
        $post = BlogPost::factory()->create(['blog_category_id' => $category->id]);

        $this->delete(route('admin.post-categories.destroy', $category));

        $this->assertDatabaseHas('blog_posts', ['id' => $post->id, 'blog_category_id' => null]);
    }

    public function test_category_requires_a_name(): void
    {
        $this->post(route('admin.post-categories.store'), [])->assertSessionHasErrors('name');

        $this->assertDatabaseCount('blog_categories', 0);
    }
}
