@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')

    <div class="row g-3 mb-4">

        <div class="col-6 col-lg">
            <a href="{{ route('admin.products.index') }}" class="text-decoration-none text-reset">
                <div class="admin-stat">
                    <div class="admin-stat-label">Products</div>
                    <div class="admin-stat-value">{{ $totalProducts }}</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg">
            <a href="{{ route('admin.partners.index') }}" class="text-decoration-none text-reset">
                <div class="admin-stat">
                    <div class="admin-stat-label">Partners</div>
                    <div class="admin-stat-value">{{ $totalPartners }}</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg">
            <a href="{{ route('admin.team.index') }}" class="text-decoration-none text-reset">
                <div class="admin-stat">
                    <div class="admin-stat-label">Team Members</div>
                    <div class="admin-stat-value">{{ $totalTeamMembers }}</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg">
            <a href="{{ route('admin.posts.index') }}" class="text-decoration-none text-reset">
                <div class="admin-stat">
                    <div class="admin-stat-label">Published Posts</div>
                    <div class="admin-stat-value">{{ $publishedPosts }}</div>
                </div>
            </a>
        </div>

        <div class="col-6 col-lg">
            <a href="{{ route('admin.messages.index') }}" class="text-decoration-none text-reset">
                <div class="admin-stat">
                    <div class="admin-stat-label">Unread Messages</div>
                    <div class="admin-stat-value">{{ $unreadMessages }}</div>
                </div>
            </a>
        </div>

    </div>


    <div class="row g-3">

        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h6 mb-0">Recent Blog Posts</h2>
                    <a href="{{ route('admin.posts.index') }}" class="small">View all</a>
                </div>

                @if ($recentPosts->isEmpty())
                    <div class="admin-empty">No blog posts yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="admin-table">
                            <tbody>
                            @foreach ($recentPosts as $post)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.posts.edit', $post) }}" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                        <small class="d-block text-muted">
                                            {{ $post->category?->name ?? 'Uncategorised' }}
                                            &middot;
                                            {{ $post->published_at?->format('d M Y') ?? 'Not scheduled' }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge {{ $post->isPublished() ? 'text-bg-success' : 'text-bg-secondary' }}">
                                            {{ $post->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h6 mb-0">Recent Messages</h2>
                    <a href="{{ route('admin.messages.index') }}" class="small">View all</a>
                </div>

                @if ($recentMessages->isEmpty())
                    <div class="admin-empty">No messages yet.</div>
                @else
                    <div class="table-responsive">
                        <table class="admin-table">
                            <tbody>
                            @foreach ($recentMessages as $message)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.messages.show', $message) }}" class="text-decoration-none">
                                            {{ $message->subject }}
                                        </a>
                                        <small class="d-block text-muted">
                                            {{ $message->name }} &middot; {{ $message->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td class="text-end">
                                        @if (! $message->is_read)
                                            <span class="badge text-bg-danger">New</span>
                                        @elseif ($message->is_replied)
                                            <span class="badge text-bg-success">Replied</span>
                                        @else
                                            <span class="badge text-bg-secondary">Read</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>

@endsection
