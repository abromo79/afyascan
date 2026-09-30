<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    use HandlesUploads;

    public function index(Request $request): View
    {
        $posts = BlogPost::with('category', 'author')
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->when($request->filled('category'), fn ($query) => $query->where('blog_category_id', $request->integer('category')))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.posts.index', [
            'posts' => $posts,
            'categories' => BlogCategory::orderBy('name')->get(),
            'filters' => $request->only('status', 'category'),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new BlogPost,
            'categories' => BlogCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->postData($request);

        $data['user_id'] = $request->user()->id;
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['featured_image'] = $this->storeImage($request->file('featured_image'), 'blog');
        $data = $this->applyStatus($data, $request);

        BlogPost::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post created.');
    }

    public function edit(BlogPost $post): View
    {
        return view('admin.posts.form', [
            'post' => $post,
            'categories' => BlogCategory::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, BlogPost $post): RedirectResponse
    {
        $data = $this->postData($request);

        if ($data['title'] !== $post->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $post->id);
        }

        $data['featured_image'] = $this->storeImage($request->file('featured_image'), 'blog', $post->featured_image);
        $data = $this->applyStatus($data, $request);

        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated.');
    }

    public function publish(BlogPost $post): RedirectResponse
    {
        $status = $post->isPublished() ? BlogPost::STATUS_DRAFT : BlogPost::STATUS_PUBLISHED;

        $post->update([
            'status' => $status,
            'published_at' => $status === BlogPost::STATUS_PUBLISHED ? ($post->published_at ?? now()) : $post->published_at,
        ]);

        return back()->with('success', $status === BlogPost::STATUS_PUBLISHED ? 'Post published.' : 'Post moved to drafts.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        $this->deleteImage($post->featured_image);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function postData(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:4096'],
        ]);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function applyStatus(array $data, Request $request): array
    {
        $status = $request->input('status', BlogPost::STATUS_DRAFT);

        $data['status'] = in_array($status, [BlogPost::STATUS_DRAFT, BlogPost::STATUS_PUBLISHED], true)
            ? $status
            : BlogPost::STATUS_DRAFT;

        $publishedAt = $request->input('published_at');
        $data['published_at'] = $publishedAt ? $publishedAt : ($data['status'] === BlogPost::STATUS_PUBLISHED ? now() : null);

        return $data;
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $suffix = 2;

        while (BlogPost::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))
            ->exists()
        ) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }
}
