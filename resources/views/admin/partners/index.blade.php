@extends('layouts.admin', ['title' => 'Partners'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Partners</h2>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg"></i> Add partner
        </a>
    </div>

    <div class="admin-card">

        @if ($partners->isEmpty())
            <div class="admin-empty">
                <p class="mb-2">No partners yet. Only partners you add here appear on the website.</p>
                <a href="{{ route('admin.partners.create') }}" class="btn btn-sm btn-primary">Add your first partner</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th style="width:80px">Logo</th>
                        <th>Name</th>
                        <th style="width:180px">Type</th>
                        <th style="width:90px">Order</th>
                        <th style="width:110px">Status</th>
                        <th style="width:150px" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($partners as $partner)
                        <tr>
                            <td>
                                @if ($partner->logo)
                                    <img src="{{ $partner->logoUrl() }}" alt="{{ $partner->name }}" class="admin-thumb">
                                @else
                                    <span class="admin-thumb d-inline-block"></span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $partner->name }}</strong>
                                @if ($partner->website)
                                    <small class="d-block">
                                        <a href="{{ $partner->website }}" target="_blank" rel="noopener">
                                            {{ $partner->website }}
                                        </a>
                                    </small>
                                @endif
                                @if ($partner->description)
                                    <small class="d-block text-muted">
                                        {{ \Illuminate\Support\Str::limit($partner->description, 90) }}
                                    </small>
                                @endif
                            </td>
                            <td>{{ $partner->partnership_type ?: '—' }}</td>
                            <td>{{ $partner->display_order }}</td>
                            <td>
                                @if ($partner->is_active)
                                    <span class="badge text-bg-success">Active</span>
                                @else
                                    <span class="badge text-bg-secondary">Inactive</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.partners.publish', $partner) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            title="{{ $partner->is_active ? 'Deactivate' : 'Activate' }}">
                                        <i class="bi bi-{{ $partner->is_active ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.partners.destroy', $partner) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete &quot;{{ $partner->name }}&quot;? This cannot be undone.');">
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
