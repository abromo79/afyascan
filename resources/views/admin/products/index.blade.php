@extends('layouts.admin', ['title' => 'Products'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add product
        </a>
    </div>

    <div class="admin-card">

        @if ($products->isEmpty())
            <div class="admin-empty">
                <p class="mb-2">No products yet.</p>
                <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">Add your first product</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th style="width:80px">Image</th>
                        <th>Name</th>
                        <th style="width:90px">Order</th>
                        <th style="width:120px">Status</th>
                        <th style="width:150px" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                @if ($product->image)
                                    <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" class="admin-thumb">
                                @else
                                    <span class="admin-thumb d-inline-block"></span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if ($product->label)
                                    <small class="d-block text-muted">{{ $product->label }}</small>
                                @endif
                                @if ($product->short_description)
                                    <small class="d-block text-muted">
                                        {{ \Illuminate\Support\Str::limit($product->short_description, 90) }}
                                    </small>
                                @endif
                            </td>
                            <td>{{ $product->display_order }}</td>
                            <td>
                                @if ($product->is_published)
                                    <span class="badge text-bg-success">Published</span>
                                @else
                                    <span class="badge text-bg-secondary">Unpublished</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.products.publish', $product) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            title="{{ $product->is_published ? 'Unpublish' : 'Publish' }}">
                                        <i class="bi bi-{{ $product->is_published ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.products.destroy', $product) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $product->name }}&quot;? This cannot be undone.');">
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
