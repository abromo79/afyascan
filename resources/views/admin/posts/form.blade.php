@extends('layouts.admin', ['title' => $post->exists ? 'Edit post' : 'Add post'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $post->exists ? 'Edit post' : 'Add post' }}</h2>
        <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}">
        @csrf
        @if ($post->exists)
            @method('PUT')
        @endif

        <div class="row g-3">

            <div class="col-lg-8">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Excerpt</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                        @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="18">{{ old('content', $post->content) }}</textarea>
                        <div class="form-text">Basic HTML is allowed, e.g. <code>&lt;p&gt;</code>, <code>&lt;h3&gt;</code>, <code>&lt;ul&gt;</code>.</div>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Draft</option>
                            <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publication date</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at"
                               value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
                        <div class="form-text">Leave empty to publish immediately when status is Published.</div>
                        @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="blog_category_id" class="form-label">Category</label>
                        <select class="form-select @error('blog_category_id') is-invalid @enderror"
                                id="blog_category_id" name="blog_category_id">
                            <option value="">Uncategorised</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @selected((string) old('blog_category_id', $post->blog_category_id) === (string) $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('blog_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Featured image</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror"
                               id="featured_image" name="featured_image" accept="image/*">
                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        @if ($post->featured_image)
                            <img src="{{ $post->featuredImageUrl() }}" alt="" class="admin-icon-preview mt-2">
                        @endif
                    </div>

                    @if ($post->exists)
                        <div class="small text-muted">
                            <div><strong>Slug:</strong> /{{ $post->slug }}</div>
                            @if ($post->author)
                                <div><strong>Author:</strong> {{ $post->author->name }}</div>
                            @endif
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg"></i> {{ $post->exists ? 'Save changes' : 'Create post' }}
                </button>
            </div>

        </div>
    </form>

@endsection
