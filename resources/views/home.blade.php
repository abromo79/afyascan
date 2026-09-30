@extends('layouts.app')

@section('content')
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-center">

                    <div class="col-lg-6">
                        <div class="hero-content">

                            <div class="trust-badges mb-4" data-aos="fade-right" data-aos-delay="200">
                                <span class="badge">AI-Powered Health Innovation</span>
                            </div>

                            <h1 data-aos="fade-right" data-aos-delay="300">
                                @php
                                    $heroTitle = $settings['hero_title'] ?? null;
                                    $heroHighlight = $settings['hero_highlight'] ?? null;
                                @endphp

                                @if ($heroTitle)
                                    @if ($heroHighlight && str_contains($heroTitle, $heroHighlight))
                                        {!! str_replace(
                                            e($heroHighlight),
                                            '<span class="highlight">'.e($heroHighlight).'</span>',
                                            e($heroTitle)
                                        ) !!}
                                    @else
                                        {{ $heroTitle }}
                                    @endif
                                @else
                                    Advancing <span class="highlight">Breast Health</span> Through Artificial Intelligence
                                @endif
                            </h1>

                            <p class="hero-description" data-aos="fade-right" data-aos-delay="400">
                                {{ $settings['hero_description'] ?? 'AfyaScan is a health technology startup developing AI-powered solutions that support breast cancer awareness, risk assessment, and medical image analysis.' }}
                            </p>

                            <div class="hero-stats mb-4" data-aos="fade-right" data-aos-delay="500">
                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="2"
                                            data-purecounter-duration="2" class="purecounter"></span></h3>
                                    <p>AI Products</p>
                                </div>

                                <div class="stat-item">
                                    <h3><span data-purecounter-start="0" data-purecounter-end="1"
                                            data-purecounter-duration="2" class="purecounter"></span></h3>
                                    <p>Health Focus</p>
                                </div>

                                <div class="stat-item">
                                    <h3>AI</h3>
                                    <p>Powered Innovation</p>
                                </div>
                            </div>

                            <div class="hero-actions" data-aos="fade-right" data-aos-delay="600">
                                <a href="{{ $settings['hero_cta_url'] ?? route('products') }}" class="btn btn-primary">
                                    {{ $settings['hero_cta_label'] ?? 'Explore Our Products' }}
                                </a>

                                <a href="{{ route('about') }}" class="btn btn-outline">
                                    Learn About AfyaScan
                                </a>
                            </div>

                            <div class="emergency-contact" data-aos="fade-right" data-aos-delay="700">
                                <div class="emergency-icon">
                                    <i class="bi bi-cpu"></i>
                                </div>

                                <div class="emergency-info">
                                    <small>Health Technology</small>
                                    <strong>AI for Better Breast Health</strong>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-visual" data-aos="fade-left" data-aos-delay="400">

                            <div class="main-image">
                                @php
                                    $heroMedia = $settings['hero_media'] ?? null;
                                    $heroMediaUrl = $heroMedia
                                        ? \Illuminate\Support\Facades\Storage::disk('public')->url($heroMedia)
                                        : asset('assets/img/AfyaScan.mp4');
                                @endphp

                                @if ($heroMedia && ! str_ends_with(strtolower($heroMedia), ['.mp4', '.webm', '.ogg']))
                                    <img src="{{ $heroMediaUrl }}" alt="AfyaScan" class="img-fluid hero-video">
                                @else
                                    <video class="img-fluid hero-video" autoplay muted loop playsinline>
                                        <source src="{{ $heroMediaUrl }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif

                                <div class="floating-card appointment-card">
                                    <div class="card-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>

                                    <div class="card-content">
                                        <h6>Risk Assessment</h6>
                                        <p>AI-Assisted</p>
                                        <small>Breast Health Awareness</small>
                                    </div>
                                </div>

                                <div class="floating-card rating-card">
                                    <div class="card-content">
                                        <div class="rating-stars">
                                            <i class="bi bi-cpu"></i>
                                            <i class="bi bi-activity"></i>
                                            <i class="bi bi-heart-pulse"></i>
                                        </div>

                                        <h6>AI Innovation</h6>
                                        <small>Health Technology</small>
                                    </div>
                                </div>
                            </div>

                            <div class="background-elements">
                                <div class="element element-1"></div>
                                <div class="element element-2"></div>
                                <div class="element element-3"></div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- About Section -->
        <section id="home-about" class="home-about section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row align-items-center">

                    <div class="col-lg-6 mb-5 mb-lg-0" data-aos="fade-right" data-aos-delay="200">
                        <div class="about-content">

                            <h2 class="section-heading">
                                Technology for Better Breast Health
                            </h2>

                            <p class="lead-text">
                                AfyaScan is building accessible and innovative AI-powered solutions to improve breast
                                health awareness and support earlier understanding of potential risks.
                            </p>

                            <p>
                                Our approach combines artificial intelligence, machine learning, deep learning and
                                digital health technologies to develop practical tools for individuals and healthcare
                                professionals.
                            </p>

                            <div class="stats-grid">

                                <div class="stat-item">
                                    <div class="stat-number purecounter"
                                        data-purecounter-start="0"
                                        data-purecounter-end="2"
                                        data-purecounter-duration="1">
                                    </div>
                                    <div class="stat-label">AI Products</div>
                                </div>

                                <div class="stat-item">
                                    <div class="stat-number purecounter"
                                        data-purecounter-start="0"
                                        data-purecounter-end="1"
                                        data-purecounter-duration="1">
                                    </div>
                                    <div class="stat-label">Health Focus</div>
                                </div>

                                <div class="stat-item">
                                    <div class="stat-number">
                                        AI
                                    </div>
                                    <div class="stat-label">Driven Innovation</div>
                                </div>

                            </div>

                            <div class="cta-section">
                                <a href="{{ route('about') }}" class="btn-primary">
                                    Learn More About Us
                                </a>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-left" data-aos-delay="300">
                        <div class="about-visual">

                            <div class="main-image">
                                <img src="{{ asset('assets/img/afyscan1.jpeg') }}"
                                    alt="AfyaScan health technology"
                                    class="img-fluid">
                            </div>

                            <div class="floating-card">
                                <div class="card-content">

                                    <div class="icon">
                                        <i class="bi bi-heart-pulse"></i>
                                    </div>

                                    <div class="card-text">
                                        <h4>AI for Breast Health</h4>
                                        <p>Technology designed to support awareness and informed health decisions.</p>
                                    </div>

                                </div>
                            </div>

                            <div class="experience-badge">
                                <div class="badge-content">
                                    <span class="years">AI</span>
                                    <span class="text">Health Innovation</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>


        <!-- Products Section -->
        <section id="featured-departments" class="featured-departments section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Our Products</h2>
                <p>
                    AI-powered solutions designed to support breast health awareness,
                    risk understanding, and medical image analysis.
                </p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-5">

                    @foreach ($products as $index => $product)
                        <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="{{ 100 + ($index * 100) }}">
                            <div class="specialty-card">

                                <div class="specialty-content">

                                    <div class="specialty-meta">
                                        <span class="specialty-label">{{ $product->label ?? 'AfyaScan Product' }}</span>
                                    </div>

                                    <h3>{{ $product->name }}</h3>

                                    <p>
                                        {{ $product->short_description }}
                                    </p>

                                    @if ($product->featureList())
                                        <div class="specialty-features">
                                            @foreach ($product->featureList() as $feature)
                                                <span>
                                                    <i class="bi bi-check-circle-fill"></i>
                                                    {{ $feature }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <a href="{{ $product->detailUrl() }}" class="specialty-link">
                                        Explore {{ $product->name }}
                                        <i class="bi bi-arrow-right"></i>
                                    </a>

                                </div>

                                <div class="specialty-visual">
                                    <img src="{{ $product->image ? $product->imageUrl() : asset('assets/img/health/cardiology-1.webp') }}"
                                         alt="AfyaScan {{ $product->name }}"
                                         class="img-fluid">

                                    <div class="visual-overlay">
                                        <i class="{{ $product->icon ?: 'bi bi-shield-check' }}"></i>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <!-- Health Awareness -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="department-highlight">

                            <div class="highlight-icon">
                                <i class="bi bi-heart-pulse"></i>
                            </div>

                            <h4>Breast Health Awareness</h4>

                            <p>
                                Promoting accessible information and awareness around breast health and cancer risk.
                            </p>

                            <ul class="highlight-list">
                                <li>Health Education</li>
                                <li>Risk Awareness</li>
                                <li>Early Health Awareness</li>
                            </ul>

                            <a href="{{ route('about') }}" class="highlight-cta">
                                Learn More
                            </a>

                        </div>
                    </div>


                    <!-- Artificial Intelligence -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="department-highlight">

                            <div class="highlight-icon">
                                <i class="bi bi-cpu"></i>
                            </div>

                            <h4>Artificial Intelligence</h4>

                            <p>
                                Applying modern AI technologies to develop practical digital health solutions.
                            </p>

                            <ul class="highlight-list">
                                <li>Machine Learning</li>
                                <li>Deep Learning</li>
                                <li>Medical AI</li>
                            </ul>

                            <a href="{{ route('products') }}" class="highlight-cta">
                                Explore Products
                            </a>

                        </div>
                    </div>


                    <!-- Digital Health -->
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="department-highlight">

                            <div class="highlight-icon">
                                <i class="bi bi-globe2"></i>
                            </div>

                            <h4>Digital Health</h4>

                            <p>
                                Building technology that connects health awareness, intelligent systems, and accessible
                                digital experiences.
                            </p>

                            <ul class="highlight-list">
                                <li>Accessible Technology</li>
                                <li>Digital Innovation</li>
                                <li>Health Technology</li>
                            </ul>

                            <a href="{{ route('contact') }}" class="highlight-cta">
                                Partner With Us
                            </a>

                        </div>
                    </div>

                </div>


                <!-- Technology Banner -->
                <div class="emergency-banner" data-aos="fade-up" data-aos-delay="400">

                    <div class="row align-items-center">

                        <div class="col-lg-8">
                            <div class="emergency-content">

                                <h3>Building the Future of AI-Powered Breast Health</h3>

                                <p>
                                    AfyaScan combines artificial intelligence, machine learning, deep learning and
                                    digital health innovation to create solutions that support breast health awareness
                                    and healthcare innovation.
                                </p>

                            </div>
                        </div>

                        <div class="col-lg-4 text-lg-end">

                            <a href="{{ route('products') }}" class="emergency-btn">
                                <i class="bi bi-arrow-right-circle"></i>
                                Explore Our Products
                            </a>

                        </div>

                    </div>

                </div>

            </div>
        </section>


        <!-- Services / Capabilities Section -->
        <section id="featured-services" class="featured-services section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Our Innovation</h2>

                <p>
                    We develop technology-driven solutions focused on improving access to
                    breast health information and AI-assisted healthcare tools.
                </p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row g-0">

                    <div class="col-lg-8" data-aos="fade-right" data-aos-delay="200">

                        <div class="featured-service-main">

                            <div class="service-image-wrapper">

                                <img src="{{ asset('assets/img/barner.jpg') }}"
                                    alt="AfyaScan AI health innovation"
                                    class="img-fluid"
                                    loading="lazy">

                                <div class="service-overlay">

                                    <div class="service-badge">
                                        <i class="bi bi-cpu"></i>
                                        <span>AI Health Innovation</span>
                                    </div>

                                </div>

                            </div>

                            <div class="service-details">

                                <h2>Technology Meets Breast Health</h2>

                                <p>
                                    AfyaScan is developing intelligent digital solutions that bring artificial
                                    intelligence into breast health awareness and medical image analysis.
                                    Our goal is to make emerging health technologies more practical, accessible,
                                    and useful.
                                </p>

                                <a href="{{ route('products') }}" class="main-cta">
                                    Explore Our Products
                                </a>

                            </div>

                        </div>

                    </div>


                    <div class="col-lg-4" data-aos="fade-left" data-aos-delay="300">

                        <div class="services-sidebar">

                            <div class="service-item" data-aos="fade-up" data-aos-delay="400">

                                <div class="service-icon-wrapper">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <div class="service-info">

                                    <h4>Risk Assessment</h4>

                                    <p>
                                        AI-assisted assessment designed to improve understanding of breast cancer
                                        risk factors.
                                    </p>

                                    <a href="{{ route('products.risk-assessment') }}" class="service-link">
                                        Learn More
                                    </a>

                                </div>

                            </div>


                            <div class="service-item" data-aos="fade-up" data-aos-delay="500">

                                <div class="service-icon-wrapper">
                                    <i class="bi bi-image"></i>
                                </div>

                                <div class="service-info">

                                    <h4>AI Image Analysis</h4>

                                    <p>
                                        AI-assisted analysis of breast-related medical images to support professional
                                        evaluation.
                                    </p>

                                    <a href="{{ route('products.image-analysis') }}" class="service-link">
                                        Learn More
                                    </a>

                                </div>

                            </div>


                            <div class="service-item" data-aos="fade-up" data-aos-delay="600">

                                <div class="service-icon-wrapper">
                                    <i class="bi bi-lightbulb"></i>
                                </div>

                                <div class="service-info">

                                    <h4>Health Innovation</h4>

                                    <p>
                                        Research and development focused on practical applications of AI in digital
                                        health.
                                    </p>

                                    <a href="{{ route('about') }}" class="service-link">
                                        Learn More
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Innovation Areas -->
                <div class="specialties-grid" data-aos="fade-up" data-aos-delay="300">

                    <div class="row align-items-center">

                        <div class="col-lg-3 col-md-6">

                            <div class="specialty-card">

                                <div class="specialty-image">
                                    <img src="{{ asset('assets/img/health/maternal-2.webp') }}"
                                        alt="Health Awareness"
                                        class="img-fluid"
                                        loading="lazy">
                                </div>

                                <div class="specialty-content">
                                    <h5>Health Awareness</h5>
                                    <span>Supporting informed breast health awareness</span>
                                </div>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="specialty-card">

                                <div class="specialty-image">
                                    <img src="{{ asset('assets/img/health/vaccination-3.webp') }}"
                                        alt="Machine Learning"
                                        class="img-fluid"
                                        loading="lazy">
                                </div>

                                <div class="specialty-content">
                                    <h5>Machine Learning</h5>
                                    <span>Data-driven AI health innovation</span>
                                </div>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="specialty-card">

                                <div class="specialty-image">
                                    <img src="{{ asset('assets/img/report.png') }}"
                                        alt="Deep Learning"
                                        class="img-fluid"
                                        loading="lazy">
                                </div>

                                <div class="specialty-content">
                                    <h5>Deep Learning</h5>
                                    <span>Advanced AI for medical image analysis</span>
                                </div>

                            </div>

                        </div>


                        <div class="col-lg-3 col-md-6">

                            <div class="specialty-card">

                                <div class="specialty-image">
                                    <img src="{{ asset('assets/img/health/facilities-6.webp') }}"
                                        alt="Digital Health Technology"
                                        class="img-fluid"
                                        loading="lazy">
                                </div>

                                <div class="specialty-content">
                                    <h5>Digital Health</h5>
                                    <span>Technology designed around health needs</span>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </section>


        <!-- Team & Innovation Section -->
        <section id="find-a-doctor" class="find-a-doctor section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Meet Our Team</h2>
                <p>
                    Leadership, medical expertise, and innovation working together to advance
                    responsible and accessible health technology.
                </p>
            </div>

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="doctors-grid" data-aos="fade-up" data-aos-delay="300">

                    @forelse ($team as $index => $member)
                        <div class="doctor-profile" data-aos="zoom-in" data-aos-delay="{{ 100 + ($index * 100) }}">
                            <div class="profile-header">
                                <div class="doctor-avatar">
                                    <img src="{{ $member->photo ? $member->photoUrl() : asset('assets/img/health/staff-2.webp') }}"
                                         alt="{{ $member->name }}"
                                         class="img-fluid">
                                    <div class="status-indicator available"></div>
                                </div>
                                <div class="doctor-details">
                                    <h4>{{ $member->name }}</h4>
                                    <span class="specialty-tag">{{ $member->position }}</span>
                                    @if ($member->bio)
                                        <div class="experience-info">
                                            <i class="bi bi-briefcase"></i>
                                            <span>{{ \Illuminate\Support\Str::limit($member->bio, 70) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="rating-section">
                                <div class="stars">
                                    @if ($member->email)
                                        <a href="mailto:{{ $member->email }}" aria-label="Email {{ $member->name }}">
                                            <i class="bi bi-envelope"></i>
                                        </a>
                                    @endif

                                    @if ($member->linkedin)
                                        <a href="{{ $member->linkedin }}" target="_blank" rel="noopener" aria-label="{{ $member->name }} on LinkedIn">
                                            <i class="bi bi-linkedin"></i>
                                        </a>
                                    @endif

                                    @if ($member->website)
                                        <a href="{{ $member->website }}" target="_blank" rel="noopener" aria-label="{{ $member->name }} website">
                                            <i class="bi bi-globe"></i>
                                        </a>
                                    @endif
                                </div>
                                <span class="rating-score">{{ $member->position }}</span>
                            </div>

                            <div class="action-buttons">
                                <button type="button"
                                        class="btn-secondary team-story-trigger"
                                        data-team-name="{{ $member->name }}"
                                        data-team-position="{{ $member->position }}"
                                        data-team-bio="{{ e($member->bio ?: 'No biography available for this team member yet.') }}">
                                    Our Story
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted w-100 mb-0">
                            Our team is being updated. Please check back soon.
                        </p>
                    @endforelse

                </div>

                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="700">
                    <a href="{{ route('products') }}" class="btn-view-all">
                        Explore All Products
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

            </div>
        </section>


        <!-- Call To Action -->
        <section id="call-to-action" class="call-to-action section light-background">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="hero-content">

                    <div class="row align-items-center">

                        <div class="col-lg-6">

                            <div class="content-wrapper" data-aos="fade-up" data-aos-delay="200">

                                <h1>
                                    Building a Smarter Future for Breast Health
                                </h1>

                                <p>
                                    AfyaScan is developing AI-powered solutions that connect health awareness,
                                    artificial intelligence, and digital innovation. Explore our products and
                                    discover how we are working to advance breast health technology.
                                </p>

                                <div class="cta-wrapper">

                                    <a href="{{ route('contact') }}" class="primary-cta">
                                        <span>Partner With AfyaScan</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>

                                    <a href="{{ route('products') }}" class="secondary-cta">
                                        <span>Explore Our Products</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>

                                </div>

                            </div>

                        </div>


                        <div class="col-lg-6">

                            <div class="image-container" data-aos="fade-left" data-aos-delay="300">

                                <img src="{{ asset('assets/img/wzrelimu.png') }}"
                                    alt="AfyaScan AI health innovation"
                                    class="img-fluid">

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Features -->
                <div class="features-section">

                    <div class="row g-0">

                        <div class="col-lg-4">

                            <div class="feature-block" data-aos="fade-up" data-aos-delay="200">

                                <div class="feature-icon">
                                    <i class="bi bi-cpu"></i>
                                </div>

                                <h3>AI-Powered Innovation</h3>

                                <p>
                                    We apply artificial intelligence, machine learning, and deep learning to develop
                                    innovative health technology solutions.
                                </p>

                            </div>

                        </div>


                        <div class="col-lg-4">

                            <div class="feature-block" data-aos="fade-up" data-aos-delay="300">

                                <div class="feature-icon">
                                    <i class="bi bi-shield-check"></i>
                                </div>

                                <h3>Responsible Technology</h3>

                                <p>
                                    We aim to develop health technologies with responsible design, privacy awareness,
                                    and a strong focus on safe and meaningful use.
                                </p>

                            </div>

                        </div>


                        <div class="col-lg-4">

                            <div class="feature-block" data-aos="fade-up" data-aos-delay="400">

                                <div class="feature-icon">
                                    <i class="bi bi-people"></i>
                                </div>

                                <h3>Collaboration</h3>

                                <p>
                                    We work toward collaboration with healthcare professionals, researchers,
                                    institutions, and technology partners to advance digital health innovation.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                <!-- Contact Block -->
                <div class="contact-block">

                    <div class="row">

                        <div class="col-lg-8">

                            <div class="contact-content" data-aos="fade-up" data-aos-delay="200">

                                <h2>Have an Idea or Want to Collaborate?</h2>

                                <p>
                                    Whether you are a healthcare professional, researcher, institution, investor,
                                    technology partner, or organization interested in digital health innovation,
                                    we would like to hear from you.
                                </p>

                            </div>

                        </div>


                        <div class="col-lg-4">

                            <div class="contact-actions" data-aos="fade-up" data-aos-delay="300">

                                <a href="{{ route('contact') }}" class="emergency-call">
                                    <i class="bi bi-envelope"></i>
                                    <span>Contact AfyaScan</span>
                                </a>

                                <a href="{{ route('contact') }}" class="contact-link">
                                    Get In Touch
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <div id="team-story-modal" aria-hidden="true" style="position:fixed; inset:0; display:none; align-items:center; justify-content:center; background:rgba(12,18,30,0.6); z-index:2000; padding:1.5rem;">
        <div style="position:relative; width:min(100%, 540px); background:#fff; border-radius:18px; box-shadow:0 24px 70px rgba(0,0,0,0.25); padding:2rem 1.5rem 1.5rem;">
            <button type="button" class="team-story-close" aria-label="Close story" style="position:absolute; top:1rem; right:1rem; border:none; background:transparent; font-size:1.75rem; line-height:1; cursor:pointer; color:#243b53;">&times;</button>
            <p id="team-story-role" style="margin:0 0 0.5rem; color:#0b8c82; font-weight:700; letter-spacing:0.04em; text-transform:uppercase; font-size:0.72rem;"></p>
            <h3 id="team-story-title" style="margin:0 0 1rem; color:#1f2d3d; font-size:1.75rem; line-height:1.2;"></h3>
            <p id="team-story-bio" style="margin:0; color:#46556b; line-height:1.7; font-size:1rem;"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('team-story-modal');
            const title = document.getElementById('team-story-title');
            const role = document.getElementById('team-story-role');
            const bio = document.getElementById('team-story-bio');
            const closeButton = document.querySelector('.team-story-close');

            if (!modal || !title || !role || !bio || !closeButton) {
                return;
            }

            document.querySelectorAll('.team-story-trigger').forEach(function (button) {
                button.addEventListener('click', function () {
                    title.textContent = button.dataset.teamName || 'Our Team';
                    role.textContent = button.dataset.teamPosition || 'Team Member';
                    bio.textContent = button.dataset.teamBio || 'No biography available for this team member yet.';
                    modal.style.display = 'flex';
                    modal.setAttribute('aria-hidden', 'false');
                });
            });

            function closeModal() {
                modal.style.display = 'none';
                modal.setAttribute('aria-hidden', 'true');
            }

            closeButton.addEventListener('click', closeModal);
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.style.display === 'flex') {
                    closeModal();
                }
            });
        });
    </script>
@endsection
