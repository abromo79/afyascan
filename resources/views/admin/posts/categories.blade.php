@extends('layouts.admin', ['title' => 'Blog Categories'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Blog Categories</h2>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.posts.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Posts
            </a>
            <a href="{{ route('admin.post-categories.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg"></i> Add category
            </a>
        </div>
    </div>

    <div class="admin-card">
        @if ($categories->isEmpty())
            <div class="admin-empty">
                <p class="mb-2">No categories yet.</p>
                <a href="{{ route('admin.post-categories.create') }}" class="btn btn-sm btn-primary">Add a category</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th style="width:200px">Slug</th>
                        <th style="width:100px">Posts</th>
                        <th style="width:110px" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><small class="text-muted">{{ $category->slug }}</small></td>
                            <td>{{ $category->posts_count }}</td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.post-categories.edit', $category) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.post-categories.destroy', $category) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete the &quot;{{ $category->name }}&quot; category? Its posts will become uncategorised.');">
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
        @endif
    </div>

@endsection
