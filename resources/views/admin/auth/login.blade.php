<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Sign in &middot; AfyaScan Admin</title>

    <link rel="icon" href="{{ asset('assets/img/logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
</head>
<body>

<div class="admin-login">

    <div class="admin-login-card">

        <div class="text-center mb-4">
            <img src="{{ asset('assets/img/logo1.png') }}" alt="AfyaScan" style="height:48px; width:auto;">
            <h1 class="h5 mt-3 mb-1">AfyaScan Admin</h1>
            <p class="text-muted small mb-0">Sign in to manage the website.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger py-2 small">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger py-2 small">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       required>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox"
                       class="form-check-input"
                       id="remember"
                       name="remember"
                       value="1"
                       @checked(old('remember'))>
                <label class="form-check-label small" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Sign in</button>
        </form>

        <div class="text-center mt-3">
            <a href="{{ route('home') }}" class="small text-muted">
                <i class="bi bi-arrow-left"></i> Back to website
            </a>
        </div>

    </div>

</div>

</body>
</html>
