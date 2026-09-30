@extends('layouts.admin', ['title' => 'Message'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">{{ $message->subject }}</h2>
        <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="row g-3">

        <div class="col-lg-8">
            <div class="admin-card h-100">
                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <div class="text-muted small">From</div>
                        <div class="fw-semibold">{{ $message->name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Email</div>
                        <div>
                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                        </div>
                    </div>

                    @if ($message->organization)
                        <div class="col-sm-6">
                            <div class="text-muted small">Organization</div>
                            <div>{{ $message->organization }}</div>
                        </div>
                    @endif

                    <div class="col-sm-6">
                        <div class="text-muted small">Received</div>
                        <div>{{ $message->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>

                <hr>

                <div style="white-space: pre-wrap">{{ $message->message }}</div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-3">
                <h3 class="h6 mb-3">Status</h3>

                <dl class="row mb-0 small">
                    <dt class="col-6 text-muted fw-normal">Read</dt>
                    <dd class="col-6 text-end">{{ $message->is_read ? 'Yes' : 'No' }}</dd>

                    <dt class="col-6 text-muted fw-normal">Replied</dt>
                    <dd class="col-6 text-end">{{ $message->is_replied ? 'Yes' : 'No' }}</dd>

                    <dt class="col-6 text-muted fw-normal">Archived</dt>
                    <dd class="col-6 text-end">{{ $message->is_archived ? 'Yes' : 'No' }}</dd>
                </dl>
            </div>

            <div class="admin-card mb-3">
                <a href="mailto:{{ $message->email }}?subject={{ rawurlencode('Re: '.$message->subject) }}"
                   class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-reply"></i> Reply by email
                </a>

                <form method="POST" action="{{ route('admin.messages.update', $message) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="is_read" value="1">
                    <input type="hidden" name="is_replied" value="{{ $message->is_replied ? 0 : 1 }}">
                    <input type="hidden" name="is_archived" value="{{ $message->is_archived ? 1 : 0 }}">
                    <button type="submit" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="bi bi-check2"></i>
                        {{ $message->is_replied ? 'Mark as not replied' : 'Mark as replied' }}
                    </button>
                </form>

                <form method="POST" action="{{ route('admin.messages.update', $message) }}">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="is_read" value="1">
                    <input type="hidden" name="is_replied" value="{{ $message->is_replied ? 1 : 0 }}">
                    <input type="hidden" name="is_archived" value="{{ $message->is_archived ? 0 : 1 }}">
                    <button type="submit" class="btn btn-outline-secondary w-100 mb-2">
                        <i class="bi bi-archive"></i>
                        {{ $message->is_archived ? 'Restore from archive' : 'Archive' }}
                    </button>
                </form>

                <form method="POST"
                      action="{{ route('admin.messages.destroy', $message) }}"
                      onsubmit="return confirm('Delete this message? This cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

    </div>

@endsection
