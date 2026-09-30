<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $title ?? 'Admin' }} &middot; AfyaScan Admin</title>

    <link rel="icon" href="{{ asset('assets/img/logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body class="admin-body">

<aside class="admin-sidebar" id="adminSidebar">
    <div class="admin-brand">
        <img src="{{ asset('assets/img/logo1.png') }}" alt="AfyaScan">
        <span>AfyaScan Admin</span>

        <button class="admin-sidebar-close"
                type="button"
                data-sidebar-toggle
                aria-label="Close navigation">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="nav flex-column">
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a>

        <a href="{{ route('admin.partners.index') }}"
           class="nav-link {{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
            <i class="bi bi-handshake"></i> Partners
        </a>

        <a href="{{ route('admin.team.index') }}"
           class="nav-link {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Team
        </a>

        <a href="{{ route('admin.posts.index') }}"
           class="nav-link {{ request()->routeIs('admin.posts.*', 'admin.post-categories.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Blog
        </a>

        <a href="{{ route('admin.messages.index') }}"
           class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
            <i class="bi bi-envelope"></i> Messages
            @if (($unreadMessages ?? 0) > 0)
                <span class="badge text-bg-danger">{{ $unreadMessages }}</span>
            @endif
        </a>

        @if (auth()->user()?->isAdmin())
            <a href="{{ route('admin.users.index') }}"
               class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i> Users
            </a>

            <a href="{{ route('admin.settings.edit') }}"
               class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Settings
            </a>
        @endif
    </nav>
</aside>

<div class="admin-sidebar-backdrop" data-sidebar-toggle></div>

<div class="admin-main">

    <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary admin-toggle"
                    type="button"
                    data-sidebar-toggle
                    aria-label="Toggle navigation"
                    aria-expanded="false"
                    aria-controls="adminSidebar">
                <i class="bi bi-list"></i>
            </button>

            <h1 class="admin-title">{{ $title ?? 'Dashboard' }}</h1>
        </div>

        <div class="admin-user-chip">
            <span class="d-none d-sm-inline text-end">
                <strong class="d-block">{{ auth()->user()?->name }}</strong>
                <small class="text-muted">{{ auth()->user()?->role }}</small>
            </span>

            <span class="admin-avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'A', 0, 1)) }}</span>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-box-arrow-right"></i>
                    <span class="d-none d-sm-inline">Logout</span>
                </button>
            </form>
        </div>
    </header>

    <main class="admin-content">
        @include('admin.partials.flash')
        @include('admin.partials.errors')

        @yield('content')
    </main>

</div>

<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script>
    (function () {
        var sidebar = document.getElementById('adminSidebar');
        var toggle = document.querySelector('.admin-toggle');

        function setSidebarOpen(open) {
            sidebar.classList.toggle('show', open);
            document.body.classList.toggle('sidebar-open', open);
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        }

        document.querySelectorAll('[data-sidebar-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                setSidebarOpen(!sidebar.classList.contains('show'));
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setSidebarOpen(false);
            }
        });
    })();
</script>
@stack('scripts')
</body>
</html>
