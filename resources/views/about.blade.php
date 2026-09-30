@extends('layouts.app')

@section('content')
    <main class="main">

        <div class="page-title">
            <div class="heading">
                <div class="container">
                    <div class="row d-flex justify-content-center text-center">
                        <div class="col-lg-8">
                            <h1 class="heading-title">About AfyaScan</h1>
                            <p class="mb-0">
                                AfyaScan is a health technology startup developing responsible,
                                accessible, and AI-powered solutions to support better breast health
                                awareness and digital healthcare innovation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="current">About</li>
                    </ol>
                </div>
            </nav>
        </div>

        <section id="about" class="about section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
                        <div class="about-content">

                            <h2>Technology for Better Breast Health</h2>

                            <p class="lead">
                                AfyaScan is building AI-powered health technology designed to make
                                breast health information, risk assessment, and medical image analysis
                                more accessible through responsible digital innovation.
                            </p>

                            <p>
                                Our approach combines artificial intelligence, machine learning,
                                digital health, and user-focused technology to develop solutions that
                                can support breast health awareness and assist healthcare professionals.
                                AfyaScan is committed to developing technology responsibly while keeping
                                accessibility, privacy, and human-centered healthcare at the core of its work.
                            </p>

                            <div class="stats-grid">
                                <div class="stat-item">
                                    <span class="stat-number">2</span>
                                    <span class="stat-label">AI Health Products</span>
                                </div>

                                <div class="stat-item">
                                    <span class="stat-number">AI</span>
                                    <span class="stat-label">Powered Innovation</span>
                                </div>

                                <div class="stat-item">
                                    <span class="stat-number">1</span>
                                    <span class="stat-label">Health Focus</span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="200">
                        <div class="image-wrapper">
                            <img src="{{ asset('assets/img/abt2.png') }}"
                                 class="img-fluid main-image"
                                 alt="AfyaScan digital health innovation">

                            <div class="floating-image" data-aos="zoom-in" data-aos-delay="400">
                                <img src="{{ asset('assets/img/abt1.png') }}"
                                     class="img-fluid"
                                     alt="AfyaScan health technology">
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Mission & Vision --}}
                <div class="values-section" data-aos="fade-up" data-aos-delay="300">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Our Mission & Vision</h3>
                            <p class="section-description">
                                Our purpose and long-term direction in transforming breast health through technology
                            </p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-bullseye"></i>
                                </div>

                                <h4>Our Mission</h4>

                                <p>
                                    To develop responsible and accessible AI-powered health solutions
                                    that improve breast health awareness, support risk assessment,
                                    and assist healthcare professionals through innovative digital technology.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-eye"></i>
                                </div>

                                <h4>Our Vision</h4>

                                <p>
                                    To become a leading African health technology company using
                                    artificial intelligence and digital innovation to create a smarter,
                                    more accessible, and technology-driven future for breast health.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- Core Values --}}
                <div class="values-section" data-aos="fade-up" data-aos-delay="300">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Our Core Values</h3>
                            <p class="section-description">
                                These principles guide how we build technology and contribute to better healthcare
                            </p>
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-heart-pulse"></i>
                                </div>

                                <h4>Impact</h4>

                                <p>
                                    Developing technology with a meaningful purpose for individuals,
                                    communities, and healthcare systems.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <h4>Responsibility</h4>

                                <p>
                                    Building AI and digital health solutions with privacy, safety,
                                    transparency, and responsible innovation in mind.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <h4>Accessibility</h4>

                                <p>
                                    Creating technology that can help make useful breast health
                                    information and digital healthcare solutions more accessible.
                                </p>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                            <div class="value-item">
                                <div class="value-icon">
                                    <i class="bi bi-lightbulb"></i>
                                </div>

                                <h4>Innovation</h4>

                                <p>
                                    Continuously exploring artificial intelligence and emerging
                                    technologies to develop better health solutions.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- Sponsors & Partners --}}
                <div class="certifications-section" data-aos="fade-up" data-aos-delay="400">

                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h3>Sponsors &amp; Partners</h3>

                            <p class="section-description">
                                AfyaScan works with institutions, organizations, and innovation partners
                                that support our journey in developing responsible AI-powered health solutions.
                            </p>
                        </div>
                    </div>

                    <div class="row justify-content-center">

                        @forelse ($partners as $index => $partner)
                            <div class="col-lg-2 col-md-3 col-sm-4 col-6"
                                 data-aos="zoom-in"
                                 data-aos-delay="{{ 100 + ($index * 100) }}">
                                <div class="certification-item">
                                    <img src="{{ $partner->logo ? $partner->logoUrl() : asset('assets/img/clients/clients-1.webp') }}"
                                         class="img-fluid"
                                         alt="{{ $partner->name }}">
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted mb-0">
                                    Our sponsors and partners are being updated. Please check back soon.
                                </p>
                            </div>
                        @endforelse

                    </div>
                </div>

            </div>
        </section>

    </main>
@endsection
