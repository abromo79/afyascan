@extends('layouts.admin', ['title' => $category->exists ? 'Edit category' : 'Add category'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $category->exists ? 'Edit category' : 'Add category' }}</h2>
        <a href="{{ route('admin.post-categories.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <form method="POST"
                  action="{{ $category->exists ? route('admin.post-categories.update', $category) : route('admin.post-categories.store') }}">
                @csrf
                @if ($category->exists)
                    @method('PUT')
                @endif

                <div class="admin-card">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug <span class="text-muted small">(optional)</span></label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                               id="slug" name="slug" value="{{ old('slug', $category->slug) }}"
                               placeholder="generated-from-name">
                        @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> {{ $category->exists ? 'Save changes' : 'Create category' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
