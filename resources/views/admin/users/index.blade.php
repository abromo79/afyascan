@extends('layouts.admin', ['title' => 'Users'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Admin Users</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add user
        </a>
    </div>

    <div class="admin-card">
        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th style="width:240px">Email</th>
                    <th style="width:120px">Role</th>
                    <th style="width:120px">Status</th>
                    <th style="width:150px" class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <strong>{{ $user->name }}</strong>
                            @if ($user->id === auth()->id())
                                <span class="badge text-bg-info ms-1">You</span>
                            @endif
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->isAdmin() ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td>
                            @if ($user->is_active)
                                <span class="badge text-bg-success">Active</span>
                            @else
                                <span class="badge text-bg-secondary">Disabled</span>
                            @endif
                        </td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            @if ($user->id !== auth()->id())
                                <form method="POST"
                                      action="{{ route('admin.users.destroy', $user) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $user->name }}&quot;? This cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <p class="text-muted small mt-3">
        <strong>ADMIN</strong> has full access.
        <strong>EDITOR</strong> can manage products, partners, team, blog and messages.
    </p>

@endsection
