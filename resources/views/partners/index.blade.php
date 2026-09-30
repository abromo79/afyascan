@extends('layouts.app')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="heading-title">Our Partners</h1>
                        <p class="mb-0">
                            AfyaScan collaborates with institutions, organizations, researchers,
                            healthcare stakeholders, and innovation partners to advance responsible
                            AI-powered solutions for better breast health.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Partners</li>
                </ol>
            </div>
        </nav>
    </div>
    <!-- End Page Title -->


    <!-- Partners Section -->
    <section id="doctors" class="doctors section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                @forelse ($partners as $index => $partner)
                    <div class="col-lg-3 col-md-6"
                         data-aos="fade-up"
                         data-aos-delay="{{ 100 + ($index * 50) }}">

                        <div class="doctor-card">

                            <div class="doctor-image">
                                <img src="{{ $partner->logo ? $partner->logoUrl() : asset('assets/img/health/staff-1.webp') }}"
                                     alt="{{ $partner->name }}"
                                     class="img-fluid">

                                <div class="doctor-overlay">
                                    <div class="social-links">
                                        @if ($partner->website)
                                            <a href="{{ $partner->website }}"
                                               target="_blank"
                                               rel="noopener"
                                               aria-label="{{ $partner->name }} website">
                                                <i class="bi bi-globe"></i>
                                            </a>
                                        @endif

                                        <a href="mailto:{{ \App\Models\SiteSetting::value('main_email', 'info@afyascan.com') }}"
                                           aria-label="Email AfyaScan">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="doctor-content">

                                <h4>{{ $partner->name }}</h4>

                                @if ($partner->partnership_type)
                                    <span class="specialty">
                                        {{ $partner->partnership_type }}
                                    </span>
                                @endif

                                @if ($partner->description)
                                    <p>
                                        {{ $partner->description }}
                                    </p>
                                @endif

                            </div>
                        </div>

                    </div>
                    <!-- End Partner Card -->
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">
                            Our partner list is being updated. Please check back soon.
                        </p>
                    </div>
                @endforelse

            </div>

        </div>

    </section>
    <!-- /Partners Section -->

</main>
@endsection
