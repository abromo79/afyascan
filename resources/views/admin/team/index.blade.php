@extends('layouts.admin', ['title' => 'Team'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Team</h2>
        <a href="{{ route('admin.team.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add team member
        </a>
    </div>

    <div class="admin-card">

        @if ($members->isEmpty())
            <div class="admin-empty">
                <p class="mb-2">No team members yet. Only members you add here appear in the website team section.</p>
                <a href="{{ route('admin.team.create') }}" class="btn btn-sm btn-primary">Add the first team member</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th style="width:80px">Photo</th>
                        <th>Name</th>
                        <th style="width:180px">Position</th>
                        <th style="width:90px">Order</th>
                        <th style="width:110px">Status</th>
                        <th style="width:150px" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($members as $member)
                        <tr>
                            <td>
                                @if ($member->photo)
                                    <img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}" class="admin-thumb">
                                @else
                                    <span class="admin-thumb d-inline-block"></span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $member->name }}</strong>
                                @if ($member->email)
                                    <small class="d-block text-muted">{{ $member->email }}</small>
                                @endif
                                @if ($member->bio)
                                    <small class="d-block text-muted">
                                        {{ \Illuminate\Support\Str::limit($member->bio, 90) }}
                                    </small>
                                @endif
                            </td>
                            <td>{{ $member->position }}</td>
                            <td>{{ $member->display_order }}</td>
                            <td>
                                @if ($member->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.team.publish', $member) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            title="{{ $member->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="bi bi-{{ $member->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.team.destroy', $member) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $member->name }}&quot;? This cannot be undone.');">
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
