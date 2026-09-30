@extends('layouts.admin', ['title' => $partner->exists ? 'Edit partner' : 'Add partner'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $partner->exists ? 'Edit partner' : 'Add partner' }}</h2>
        <a href="{{ route('admin.partners.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ $partner->exists ? route('admin.partners.update', $partner) : route('admin.partners.store') }}">
        @csrf
        @if ($partner->exists)
            @method('PUT')
        @endif

        <div class="row g-3">

            <div class="col-lg-8">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $partner->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control @error('website') is-invalid @enderror"
                               id="website" name="website" value="{{ old('website', $partner->website) }}"
                               placeholder="https://example.org">
                        @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="description" class="form-label">Short description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="5">{{ old('description', $partner->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo</label>
                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                               id="logo" name="logo" accept="image/*">
                        @error('logo')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        @if ($partner->logo)
                            <img src="{{ $partner->logoUrl() }}" alt="" class="admin-icon-preview mt-2">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="partnership_type" class="form-label">Partnership type</label>
                        <select class="form-select @error('partnership_type') is-invalid @enderror"
                                id="partnership_type" name="partnership_type">
                            <option value="">Select a type</option>
                            @foreach ($partnershipTypes as $type)
                                <option value="{{ $type }}" @selected(old('partnership_type', $partner->partnership_type) === $type)>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('partnership_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display order</label>
                        <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                               id="display_order" name="display_order" min="0"
                               value="{{ old('display_order', $partner->display_order ?? 0) }}">
                        @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                               @checked(old('is_active', $partner->is_active ?? true))>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg"></i> {{ $partner->exists ? 'Save changes' : 'Create partner' }}
                </button>
            </div>

        </div>
    </form>

@endsection
