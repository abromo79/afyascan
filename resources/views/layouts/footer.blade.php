<footer id="footer" class="footer footer-16 position-relative">
    <div class="container">
        <div class="footer-main" data-aos="fade-up" data-aos-delay="100">
            <div class="row align-items-start">
                <div class="col-lg-5">
                    <div class="brand-section">
                        <a href="{{ route('home') }}" class="logo d-flex align-items-center mb-4">
                            <span class="sitename">{{ \App\Models\SiteSetting::value('site_name', 'Afyascan') }}</span>
                        </a>
                        <p class="brand-description">Helping organizations improve care delivery, operational visibility, and patient confidence through modern digital healthcare solutions.</p>

                        <div class="contact-info mt-5">
                            @if (\App\Models\SiteSetting::value('address'))
                                <div class="contact-item">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>{{ \App\Models\SiteSetting::value('address') }}</span>
                                </div>
                            @endif

                            @if (\App\Models\SiteSetting::value('phone'))
                                <div class="contact-item">
                                    <i class="bi bi-telephone"></i>
                                    <span>{{ \App\Models\SiteSetting::value('phone') }}</span>
                                </div>
                            @endif

                            @if (\App\Models\SiteSetting::value('main_email'))
                                <div class="contact-item">
                                    <i class="bi bi-envelope"></i>
                                    <span>{{ \App\Models\SiteSetting::value('main_email') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-7">
                    <div class="footer-nav-wrapper">
                        <div class="row">
                            <div class="col-6 col-lg-3">
                                <div class="nav-column">
                                    <h6>Company</h6>
                                    <nav class="footer-nav">
                                        <a href="{{ route('about') }}">About</a>
                                        <a href="{{ route('products') }}">Products</a>
                                        <a href="{{ route('partners') }}">Partners</a>
                                        <a href="{{ route('contact') }}">Contact</a>
                                        <a href="{{ route('blog') }}">Blog</a>
                                    </nav>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3">
                                <div class="nav-column">
                                    <h6>Services</h6>
                                    <nav class="footer-nav">
                                        <a href="{{ route('contact') }}">Primary Care</a>
                                        <a href="{{ route('contact') }}">Telehealth</a>
                                        <a href="{{ route('contact') }}">Diagnostics</a>
                                        <a href="{{ route('contact') }}">Wellness Plans</a>
                                        <a href="{{ route('contact') }}">Consultation</a>
                                    </nav>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3">
                                <div class="nav-column">
                                    <h6>Resources</h6>
                                    <nav class="footer-nav">
                                        <a href="{{ route('blog') }}">Health Blog</a>
                                        <a href="{{ route('about') }}">Our Story</a>
                                        <a href="{{ route('contact') }}">Book Visit</a>
                                        <a href="{{ route('contact') }}">Support</a>
                                        <a href="{{ route('home') }}">FAQs</a>
                                    </nav>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3">
                                <div class="nav-column">
                                    <h6>Connect</h6>
                                    <nav class="footer-nav">
                                        <a href="{{ route('contact') }}">Start Project</a>
                                        <a href="{{ route('contact') }}">Schedule Call</a>
                                        <a href="{{ route('contact') }}">Join Newsletter</a>
                                        <a href="{{ route('contact') }}">Follow Updates</a>
                                        <a href="{{ route('home') }}">Partnership</a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (\App\Models\SiteSetting::socialLinks())
                <div class="footer-social">
                    <div class="social-section">
                        <div class="social-links">
                            @foreach (\App\Models\SiteSetting::socialLinks() as $social)
                                <a class="social-link" href="{{ $social['url'] }}" target="_blank" rel="noopener" aria-label="{{ $social['label'] }}">
                                    <i class="bi {{ $social['icon'] }}"></i>
                                    <span>{{ $social['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="bottom-content" data-aos="fade-up" data-aos-delay="300">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="copyright">
                            @if (\App\Models\SiteSetting::value('footer_text'))
                                <p>{{ \App\Models\SiteSetting::value('footer_text') }}</p>
                            @else
                                <p>© <span class="sitename">{{ \App\Models\SiteSetting::value('site_name', 'Afyascan') }}</span>. All rights reserved.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="legal-links">
                            <a href="{{ route('home') }}">Privacy Policy</a>
                            <a href="{{ route('home') }}">Terms of Service</a>
                            <a href="{{ route('home') }}">Cookie Policy</a>
                            <div class="credits">
                                Designed by AfyaScan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
