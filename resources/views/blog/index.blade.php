@extends('layouts.app')

@section('content')

<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">

                        <h1 class="heading-title">AfyaScan Blog</h1>

                        <p class="mb-0">
                            Explore insights, updates and knowledge about breast health,
                            artificial intelligence, digital healthcare and AfyaScan's
                            health technology innovation.
                        </p>

                    </div>
                </div>
            </div>
        </div>

        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li>
                        <a href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="current">Blog</li>
                </ol>
            </div>
        </nav>
    </div>
    <!-- End Page Title -->


    <!-- Blog Section -->
    <section id="blog" class="blog-section section">

        <div class="container-fluid"
             data-aos="fade-up"
             data-aos-delay="100">

            <div class="row gy-4 justify-content-center">
                @forelse ($posts as $post)
                    <div class="col-xl-3 col-lg-4 col-md-6">

                        <article class="blog-card h-100">
                            <a href="{{ route('blog.show', $post->slug) }}" class="d-block overflow-hidden rounded-top">
                                <img src="{{ $post->featuredImageUrl() ?? asset('assets/img/gallery/gallery-1.webp') }}"
                                     class="img-fluid w-100"
                                     alt="{{ $post->title }}"
                                     style="height: 240px; object-fit: cover;">
                            </a>

                            <div class="p-3">
                                <span class="text-primary fw-semibold d-block mb-2">
                                    {{ $post->category?->name ?? 'AfyaScan Insights' }}
                                </span>

                                <h3 class="h5 mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <p class="text-secondary mb-3">
                                    {{ $post->excerpt }}
                                </p>

                                <small class="text-muted">
                                    {{ $post->published_at?->format('d M Y') }}
                                </small>
                            </div>
                        </article>

                    </div>
                    <!-- End Blog Post -->
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">
                            No articles have been published yet. Please check back soon.
                        </p>
                    </div>
                @endforelse

            </div>

            @if ($posts->hasPages())
                <div class="mt-4">
                    {{ $posts->links('pagination::bootstrap-5') }}
                </div>
            @endif

        </div>

    </section>
    <!-- /Blog Section -->

</main>



@endsection
