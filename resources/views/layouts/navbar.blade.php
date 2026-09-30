<header id="header" class="header fixed-top">
    <div class="branding d-flex align-items-center">
        <div class="container position-relative d-flex align-items-center justify-content-between">
            <a href="{{ route('home') }}" class="logo d-flex align-items-center">
                <img src="{{ \App\Models\SiteSetting::image('site_logo', asset('assets/img/logo1.png')) }}" alt="Afyascan logo" class="logo-img me-2" style="height:40px; width:auto;" />
                <h1 class="sitename mb-0">{{ \App\Models\SiteSetting::value('site_name', 'Afyascan') }}</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">About</a></li>
                    <li><a href="{{ route('products') }}" class="{{ request()->routeIs('products*') ? 'active' : '' }}">Products</a></li>
                    <li><a href="{{ route('partners') }}" class="{{ request()->routeIs('partners') ? 'active' : '' }}">Partners</a></li>
                    <li><a href="{{ route('blog') }}" class="{{ request()->routeIs('blog*') ? 'active' : '' }}">Blog</a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </div>
</header>
