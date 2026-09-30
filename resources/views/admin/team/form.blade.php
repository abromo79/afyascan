@extends('layouts.admin', ['title' => $member->exists ? 'Edit team member' : 'Add team member'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $member->exists ? 'Edit team member' : 'Add team member' }}</h2>
        <a href="{{ route('admin.team.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <form method="POST"
          enctype="multipart/form-data"
          action="{{ $member->exists ? route('admin.team.update', $member) : route('admin.team.store') }}">
        @csrf
        @if ($member->exists)
            @method('PUT')
        @endif

        <div class="row g-3">

            <div class="col-lg-8">
                <div class="admin-card mb-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $member->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="position" class="form-label">Position / title</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position" value="{{ old('position', $member->position) }}" required>
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-muted small">(optional)</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $member->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-md-6">
                            <label for="linkedin" class="form-label">LinkedIn <span class="text-muted small">(optional)</span></label>
                            <input type="url" class="form-control @error('linkedin') is-invalid @enderror"
                                   id="linkedin" name="linkedin" value="{{ old('linkedin', $member->linkedin) }}"
                                   placeholder="https://linkedin.com/in/…">
                            @error('linkedin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="website" class="form-label">Website <span class="text-muted small">(optional)</span></label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror"
                                   id="website" name="website" value="{{ old('website', $member->website) }}"
                                   placeholder="https://…">
                            @error('website')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="bio" class="form-label">Short biography</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror"
                                      id="bio" name="bio" rows="5">{{ old('bio', $member->bio) }}</textarea>
                            @error('bio')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card mb-3">
                    <div class="mb-3">
                        <label for="photo" class="form-label">Profile photo</label>
                        <input type="file" class="form-control @error('photo') is-invalid @enderror"
                               id="photo" name="photo" accept="image/*">
                        @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror

                        @if ($member->photo)
                            <img src="{{ $member->photoUrl() }}" alt="" class="admin-icon-preview mt-2">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="display_order" class="form-label">Display order</label>
                        <input type="number" class="form-control @error('display_order') is-invalid @enderror"
                               id="display_order" name="display_order" min="0"
                               value="{{ old('display_order', $member->display_order ?? 0) }}">
                        @error('display_order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                               @checked(old('is_active', $member->is_active ?? true))>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-check-lg"></i> {{ $member->exists ? 'Save changes' : 'Create team member' }}
                </button>
            </div>

        </div>
    </form>

@endsection
