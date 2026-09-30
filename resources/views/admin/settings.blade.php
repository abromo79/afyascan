@extends('layouts.admin', ['title' => 'Settings'])

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 mb-0">Website Settings</h2>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-box-arrow-up-right"></i> View website
        </a>
    </div>

    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-3">

            <div class="col-lg-6">
                <div class="admin-card h-100">
                    <h3 class="h6 mb-3">General</h3>

                    <div class="mb-3">
                        <label for="site_name" class="form-label">Website name</label>
                        <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                               id="site_name" name="site_name"
                               value="{{ old('site_name', $settings->get('site_name')->value ?? null) }}">
                        @error('site_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="site_logo" class="form-label">Logo</label>
                        <input type="file" class="form-control @error('site_logo_file') is-invalid @enderror"
                               id="site_logo" name="site_logo_file" accept="image/*">
                        @error('site_logo_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if ($settings->get('site_logo')?->value)
                            <img src="{{ $settings->get('site_logo')->fileUrl() }}" alt="" class="admin-icon-preview mt-2">
                        @endif
                    </div>

                    <div>
                        <label for="site_favicon" class="form-label">Favicon</label>
                        <input type="file" class="form-control @error('site_favicon_file') is-invalid @enderror"
                               id="site_favicon" name="site_favicon_file" accept="image/*">
                        @error('site_favicon_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if ($settings->get('site_favicon')?->value)
                            <img src="{{ $settings->get('site_favicon')->fileUrl() }}" alt="" class="admin-icon-preview mt-2">
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="admin-card h-100">
                    <h3 class="h6 mb-3">Contact</h3>

                    <div class="mb-3">
                        <label for="main_email" class="form-label">Main email</label>
                        <input type="email" class="form-control @error('main_email') is-invalid @enderror"
                               id="main_email" name="main_email"
                               value="{{ old('main_email', $settings->get('main_email')->value ?? null) }}">
                        @error('main_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="secondary_email" class="form-label">Partnerships email</label>
                        <input type="email" class="form-control @error('secondary_email') is-invalid @enderror"
                               id="secondary_email" name="secondary_email"
                               value="{{ old('secondary_email', $settings->get('secondary_email')->value ?? null) }}">
                        @error('secondary_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                               id="phone" name="phone"
                               value="{{ old('phone', $settings->get('phone')->value ?? null) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div>
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control @error('address') is-invalid @enderror"
                                  id="address" name="address" rows="2">{{ old('address', $settings->get('address')->value ?? null) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="admin-card h-100">
                    <h3 class="h6 mb-3">Social media</h3>

                    @foreach (['facebook_url' => 'Facebook', 'linkedin_url' => 'LinkedIn', 'twitter_url' => 'X / Twitter', 'instagram_url' => 'Instagram', 'youtube_url' => 'YouTube'] as $key => $label)
                        <div class="mb-3">
                            <label for="{{ $key }}" class="form-label">{{ $label }}</label>
                            <input type="url" class="form-control @error($key) is-invalid @enderror"
                                   id="{{ $key }}" name="{{ $key }}"
                                   value="{{ old($key, $settings[$key]->value ?? null) }}"
                                   placeholder="https://">
                            @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-lg-6">
                <div class="admin-card h-100">
                    <h3 class="h6 mb-3">Home page hero</h3>

                    <div class="mb-3">
                        <label for="hero_title" class="form-label">Hero title</label>
                        <input type="text" class="form-control @error('hero_title') is-invalid @enderror"
                               id="hero_title" name="hero_title"
                               value="{{ old('hero_title', $settings->get('hero_title')->value ?? null) }}">
                        @error('hero_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="hero_highlight" class="form-label">Highlighted words</label>
                        <input type="text" class="form-control @error('hero_highlight') is-invalid @enderror"
                               id="hero_highlight" name="hero_highlight"
                               value="{{ old('hero_highlight', $settings->get('hero_highlight')->value ?? null) }}">
                        <div class="form-text">These words are highlighted inside the title.</div>
                        @error('hero_highlight')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="hero_description" class="form-label">Hero description</label>
                        <textarea class="form-control @error('hero_description') is-invalid @enderror"
                                  id="hero_description" name="hero_description" rows="3">{{ old('hero_description', $settings->get('hero_description')->value ?? null) }}</textarea>
                        @error('hero_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="hero_media" class="form-label">Hero image or video</label>
                        <input type="file" class="form-control @error('hero_media_file') is-invalid @enderror"
                               id="hero_media" name="hero_media_file" accept="image/*,video/mp4,video/webm">
                        @error('hero_media_file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if ($settings->get('hero_media')?->value)
                            <div class="form-text">Current file: {{ $settings->get('hero_media')->value }}</div>
                        @endif
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="hero_cta_label" class="form-label">Primary button label</label>
                            <input type="text" class="form-control @error('hero_cta_label') is-invalid @enderror"
                                   id="hero_cta_label" name="hero_cta_label"
                                   value="{{ old('hero_cta_label', $settings->get('hero_cta_label')->value ?? null) }}">
                            @error('hero_cta_label')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="hero_cta_url" class="form-label">Primary button URL</label>
                            <input type="text" class="form-control @error('hero_cta_url') is-invalid @enderror"
                                   id="hero_cta_url" name="hero_cta_url"
                                   value="{{ old('hero_cta_url', $settings->get('hero_cta_url')->value ?? null) }}"
                                   placeholder="/products">
                            @error('hero_cta_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="admin-card">
                    <h3 class="h6 mb-3">Footer</h3>

                    <label for="footer_text" class="form-label">Footer text</label>
                    <textarea class="form-control @error('footer_text') is-invalid @enderror"
                              id="footer_text" name="footer_text" rows="2">{{ old('footer_text', $settings->get('footer_text')->value ?? null) }}</textarea>
                    @error('footer_text')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-lg"></i> Save settings
                </button>
            </div>

        </div>
    </form>

@endsection
