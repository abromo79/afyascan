@extends('layouts.app')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="heading-title">Our Products</h1>
                        <p class="mb-0">
                            AfyaScan develops AI-powered health technology products designed to
                            support better breast health awareness, risk assessment, and medical
                            image analysis.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Products</li>
                </ol>
            </div>
        </nav>
    </div>
    <!-- End Page Title -->


    <!-- Products Section -->
    <section id="services" class="services section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                @forelse ($products as $index => $product)
                    <div class="col-lg-6 col-md-6"
                         data-aos="fade-up"
                         data-aos-delay="{{ 200 + ($index * 50) }}">

                        <div class="service-item">

                            <div class="service-image">
                                <img src="{{ $product->image ? $product->imageUrl() : asset('assets/img/health/cardiology-2.webp') }}"
                                     alt="AfyaScan {{ $product->name }}"
                                     class="img-fluid">

                                <div class="service-overlay">
                                    <i class="{{ $product->icon ?: 'fas fa-heartbeat' }}"></i>
                                </div>
                            </div>

                            <div class="service-content">

                                <h3>{{ $product->name }}</h3>

                                <p>
                                    {{ $product->short_description }}
                                </p>

                                @if ($product->featureList())
                                    <div class="service-features">

                                        @foreach ($product->featureList() as $feature)
                                            <span class="feature-item">
                                                <i class="fas fa-check"></i>
                                                {{ $feature }}
                                            </span>
                                        @endforeach

                                    </div>
                                @endif

                                <a href="{{ $product->detailUrl() }}"
                                   class="service-btn">

                                    <span>Explore Product</span>

                                    <i class="fas fa-arrow-right"></i>

                                </a>

                            </div>
                        </div>

                    </div>
                    <!-- End Product Item -->
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">Our products are being updated. Please check back soon.</p>
                    </div>
                @endforelse

            </div>

        </div>

    </section>
    <!-- /Products Section -->

</main>
@endsection
