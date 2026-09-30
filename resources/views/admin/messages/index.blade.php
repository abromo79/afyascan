@extends('layouts.admin', ['title' => 'Messages'])

@section('content')

    <h2 class="h5 mb-3">Contact Messages</h2>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="{{ route('admin.messages.index', ['filter' => 'active']) }}"
               class="nav-link {{ $filter === 'active' ? 'active' : '' }}">Active</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.messages.index', ['filter' => 'unread']) }}"
               class="nav-link {{ $filter === 'unread' ? 'active' : '' }}">Unread</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.messages.index', ['filter' => 'archived']) }}"
               class="nav-link {{ $filter === 'archived' ? 'active' : '' }}">Archived</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.messages.index', ['filter' => 'all']) }}"
               class="nav-link {{ $filter === 'all' ? 'active' : '' }}">All</a>
        </li>
    </ul>

    <div class="admin-card">
        @if ($messages->isEmpty())
            <div class="admin-empty">No messages found.</div>
        @else
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th style="width:90px">Status</th>
                        <th>Subject</th>
                        <th style="width:200px">From</th>
                        <th style="width:130px">Received</th>
                        <th style="width:110px" class="text-end">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($messages as $message)
                        <tr class="{{ $message->is_read ? '' : 'fw-semibold' }}">
                            <td>
                                @if ($message->is_archived)
                                    <span class="badge text-bg-dark">Archived</span>
                                @elseif (! $message->is_read)
                                    <span class="badge text-bg-danger">New</span>
                                @elseif ($message->is_replied)
                                    <span class="badge text-bg-success">Replied</span>
                                @else
                                    <span class="badge text-bg-secondary">Read</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.messages.show', $message) }}" class="text-decoration-none">
                                    {{ $message->subject }}
                                </a>
                            </td>
                            <td>
                                <div>{{ $message->name }}</div>
                                <small class="text-muted">{{ $message->email }}</small>
                            </td>
                            <td><small>{{ $message->created_at->format('d M Y H:i') }}</small></td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn btn-sm btn-outline-secondary" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <form method="POST" action="{{ route('admin.messages.update', $message) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_read" value="{{ $message->is_read ? 0 : 1 }}">
                                    <input type="hidden" name="is_replied" value="{{ $message->is_replied ? 1 : 0 }}">
                                    <input type="hidden" name="is_archived" value="{{ $message->is_archived ? 0 : 1 }}">
                                    <button type="submit" class="btn btn-sm btn-outline-secondary"
                                            title="{{ $message->is_archived ? 'Restore from archive' : 'Archive' }}">
                                        <i class="bi bi-archive"></i>
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.messages.destroy', $message) }}"
                                      class="d-inline"
                                      onsubmit="return confirm('Delete this message? This cannot be undone.');">
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

            <div class="mt-3">
                {{ $messages->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

@endsection
