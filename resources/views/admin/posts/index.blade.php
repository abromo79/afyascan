@extends('layouts.admin', ['title' => 'Blog'])

@section('content')

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <h2 class="h5 mb-0">Blog Posts</h2>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.post-categories.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-tags"></i> Categories
            </a>
            <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> Add post
            </a>
        </div>
    </div>

    <div class="admin-card mb-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-sm-4 col-lg-3">
                <label for="filter-status" class="form-label small mb-1">Status</label>
                <select class="form-select form-select-sm" id="filter-status" name="status">
                    <option value="">All</option>
                    <option value="published" @selected(($filters['status'] ?? '') === 'published')>Published</option>
                    <option value="draft" @selected(($filters['status'] ?? '') === 'draft')>Drafts</option>
                </select>
            </div>

            <div class="col-sm-4 col-lg-3">
                <label for="filter-category" class="form-label small mb-1">Category</label>
                <select class="form-select form-select-sm" id="filter-category" name="category">
                    <option value="">All</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) ($filters['category'] ?? '') === (string) $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-secondary">Filter</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>

    <div class="admin-card">
        @if ($posts->isEmpty())
            <div class="admin-empty">
                <p class="mb-2">No posts found.</p>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-sm btn-primary">Write your first post</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th style="width:70px">Image</th>
                        <th>Title</th>
                        <th style="width:150px">Category</th>
                        <th style="width:140px">Status</th>
                        <th style="width:110px">Date</th>
                        <th style="width:150px" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($posts as $post)
                        <tr>
                            <td>
                                @if ($post->featured_image)
                                    <img src="{{ $post->featuredImageUrl() }}" alt="" class="admin-thumb">
                                @else
                                    <span class="admin-thumb d-inline-block"></span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $post->title }}</strong>
                                <small class="d-block text-muted">/{{ $post->slug }}</small>
                            </td>
                            <td>{{ $post->category?->name ?? '—' }}</td>
                            <td>
                                @if ($post->isPublished())
                                    <span class="badge text-bg-success">Published</span>
                                @else
                                    <span class="badge text-bg-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <small>{{ $post->published_at?->format('d M Y') ?? '—' }}</small>
                            </td>
                            <td class="text-end text-nowrap">
                                @if ($post->isPublished())
                                    <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View on site">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif

                                <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.posts.publish', $post) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            title="{{ $post->isPublished() ? 'Move to drafts' : 'Publish' }}">
                                        <i class="bi bi-{{ $post->isPublished() ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.posts.destroy', $post) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $post->title }}&quot;? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

@endsection
