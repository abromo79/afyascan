@extends('layouts.app')

@section('content')
<br><br><br>
    <section class="section pt-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1>{{ $product->name ?? 'AI Image Analysis' }}</h1>
                    <p class="lead text-secondary">{{ $product->label ?? 'Transform visual data into clear insight using scalable analysis workflows.' }}</p>
                    <p>{{ $product->description ?? 'We support organisations that need faster interpretation, cleaner annotations and more dependable review processes across imaging workflows.' }}</p>

                    @if ($product?->featureList())
                        <div class="service-features">
                            @foreach ($product->featureList() as $feature)
                                <span class="feature-item">
                                    <i class="fas fa-check"></i>
                                    {{ $feature }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-lg-6">
                    <img src="{{ $product?->imageUrl() ?? asset('assets/img/health/facilities-6.webp') }}"
                         alt="{{ $product->name ?? 'Image analysis' }}"
                         class="img-fluid rounded shadow-sm">
                </div>
            </div>
        </div>
    </section>
@endsection
