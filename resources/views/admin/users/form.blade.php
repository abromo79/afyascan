@extends('layouts.admin', ['title' => $user->exists ? 'Edit user' : 'Add user'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $user->exists ? 'Edit user' : 'Add user' }}</h2>
        <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <form method="POST"
                  action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">
                @csrf
                @if ($user->exists)
                    @method('PUT')
                @endif

                <div class="admin-card">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password
                            @if ($user->exists)
                                <span class="text-muted small">(leave empty to keep current password)</span>
                            @endif
                        </label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password" @required(! $user->exists) autocomplete="new-password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation" @required(! $user->exists) autocomplete="new-password">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                            <option value="EDITOR" @selected(old('role', $user->role) === 'EDITOR')>EDITOR</option>
                            <option value="ADMIN" @selected(old('role', $user->role) === 'ADMIN')>ADMIN</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1"
                               @checked(old('is_active', $user->is_active ?? true))>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> {{ $user->exists ? 'Save changes' : 'Create user' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
