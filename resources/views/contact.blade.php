@extends('layouts.app')

@section('content')
<main class="main">

    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1 class="heading-title">Contact AfyaScan</h1>
                        <p class="mb-0">
                            Have a question about AfyaScan, our AI-powered breast health products,
                            partnerships, or collaboration opportunities? Get in touch with our team.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="current">Contact</li>
                </ol>
            </div>
        </nav>
    </div>
    <!-- End Page Title -->


    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-5">

                <!-- Contact Information -->
                <div class="col-lg-5">

                    <div class="contact-info-wrapper">

                        <!-- Address -->
                        <div class="contact-info-item"
                             data-aos="fade-up"
                             data-aos-delay="100">

                            <div class="info-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>

                            <div class="info-content">
                                <h3>Our Location</h3>
                                <p>{{ \App\Models\SiteSetting::value('address', 'Zanzibar, Tanzania') }}</p>
                            </div>

                        </div>


                        <!-- Email -->
                        <div class="contact-info-item"
                             data-aos="fade-up"
                             data-aos-delay="200">

                            <div class="info-icon">
                                <i class="bi bi-envelope"></i>
                            </div>

                            <div class="info-content">
                                <h3>Email Address</h3>
                                <p>{{ \App\Models\SiteSetting::value('main_email', 'info@afyascan.com') }}</p>

                                @if (\App\Models\SiteSetting::value('secondary_email'))
                                    <p>{{ \App\Models\SiteSetting::value('secondary_email') }}</p>
                                @endif
                            </div>

                        </div>


                        <!-- Working Hours -->
                        <div class="contact-info-item"
                             data-aos="fade-up"
                             data-aos-delay="300">

                            <div class="info-icon">
                                <i class="bi bi-headset"></i>
                            </div>

                            <div class="info-content">
                                <h3>Get in Touch</h3>
                                <p>
                                    Contact us for product information, partnerships,
                                    research collaboration, or general inquiries.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>


                <!-- Contact Form -->
                <div class="col-lg-7">

                    <div class="contact-form-card"
                         data-aos="fade-up"
                         data-aos-delay="200">

                        <h2>Send Us a Message</h2>

                        <p class="mb-4">
                            Tell us how we can help. Whether you are interested in our products,
                            partnership opportunities, research, or digital health innovation,
                            our team would be happy to hear from you.
                        </p>


                        <form action="{{ route('contact.store') }}"
                              method="POST"
                              class="php-email-form">

                            @csrf

                            @if (session('success'))
                                <div class="alert alert-success sent-message" role="alert">
                                    {{ session('success') }}
                                    Thank you for contacting AfyaScan.
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger error-message" role="alert">
                                    Please correct the following:
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="row g-4">

                                <!-- Name -->
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name"
                                           id="name"
                                           placeholder="Your Name"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>


                                <!-- Email -->
                                <div class="col-md-6">
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email"
                                           id="email"
                                           placeholder="Your Email"
                                           value="{{ old('email') }}"
                                           required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>


                                <!-- Organization -->
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control"
                                           name="organization"
                                           id="organization"
                                           placeholder="Organization (Optional)"
                                           value="{{ old('organization') }}">
                                </div>


                                <!-- Subject -->
                                <div class="col-md-6">
                                    <input type="text"
                                           class="form-control @error('subject') is-invalid @enderror"
                                           name="subject"
                                           id="subject"
                                           placeholder="Subject"
                                           value="{{ old('subject') }}"
                                           required>
                                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>


                                <!-- Message -->
                                <div class="col-12">
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              name="message"
                                              id="message"
                                              placeholder="Tell us how we can help..."
                                              rows="6"
                                              required>{{ old('message') }}</textarea>
                                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>


                                <!-- Submit -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-submit">
                                        Send Message
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>


        <!-- Location / Map -->
        <div class="container-fluid map-container"
             data-aos="fade-up"
             data-aos-delay="200">

            <div class="map-overlay"></div>

            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d39.208328!3d-6.165917!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185cd7d9b8e4f1d5%3A0x1c7f8e9f7c8a9d2a!2sZanzibar%2C%20Tanzania!5e0!3m2!1sen!2sus!4v1720000000000!5m2!1sen!2sus"
                width="100%"
                height="500"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>

        </div>

    </section>
    <!-- /Contact Section -->

</main>
@endsection
