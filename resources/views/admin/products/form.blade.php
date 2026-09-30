@extends('layouts.admin', ['title' => $product->exists ? 'Edit product' : 'Add product'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $product->exists ? 'Edit product' : 'Add product' }}</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}">
        @csrf
        @if ($product->exists)
            @method('PUT')
        @endif

        <div class="row g-3">

            <div class="col-lg-8">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="label" class="form-label">Label <span class="text-muted small">(optional small heading)</span></label>
                        <input type="text" class="form-control @error('label') is-invalid @enderror"
                               id="label" name="label" value="{{ old('label', $product->label) }}">
                        @error('label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short description</label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror"
                                  id="short_description" name="short_description" rows="3">{{ old('short_description', $product->short_description) }}</textarea>
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="6">{{ old('description', $product->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="features" class="form-label">Features <span class="text-muted small">(one per line)</span></label>
                        <textarea class="form-control @error('features') is-invalid @enderror"
                                  id="features" name="features" rows="5">{{ old('features', $product->features) }}</textarea>
                        @error('features')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               id="image" name="image" accept="image/*">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        @if ($product->image)
                            <img src="{{ $product->imageUrl() }}" alt="" class="admin-icon-preview mt-2">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="icon" class="form-label">Icon class <span class="text-muted small">(optional)</span></label>
                        <input type="text" class="form-control @error('icon') is-invalid @enderror"
                               id="icon" name="icon" value="{{ old('icon', $product->icon) }}" placeholder="fas fa-heartbeat">
                        <div class="form-text">Font Awesome class, e.g. <code>fas fa-heartbeat</code>.</div>
                        @error('icon')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display order</label>
                        <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                               id="display_order" name="display_order" min="0"
                               value="{{ old('display_order', $product->display_order ?? 0) }}">
                        @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" class="form-check-input" id="is_published" name="is_published" value="1"
                               @checked(old('is_published', $product->is_published ?? true))>
                        <label class="form-check-label" for="is_published">Published</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg"></i> {{ $product->exists ? 'Save changes' : 'Create product' }}
                </button>
            </div>

        </div>
    </form>

@endsection
