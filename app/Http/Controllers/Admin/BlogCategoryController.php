<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.categories', [
            'categories' => BlogCategory::withCount('posts')->orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.category-form', [
            'category' => new BlogCategory,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->categoryData($request);

        BlogCategory::create($data);

        return redirect()->route('admin.post-categories.index')->with('success', 'Category created.');
    }

    public function edit(BlogCategory $postCategory): View
    {
        return view('admin.posts.category-form', [
            'category' => $postCategory,
        ]);
    }

    public function update(Request $request, BlogCategory $postCategory): RedirectResponse
    {
        $postCategory->update($this->categoryData($request));

        return redirect()->route('admin.post-categories.index')->with('success', 'Category updated.');
    }

    public function destroy(BlogCategory $postCategory): RedirectResponse
    {
        $postCategory->delete();

        return redirect()->route('admin.post-categories.index')->with('success', 'Category deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function categoryData(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
        ]);

        if (blank($data['slug'] ?? null)) {
            $data['slug'] = Str::slug($data['name']);
        }

        return $data;
    }
}
