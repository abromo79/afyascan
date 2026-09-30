@extends('layouts.app')

@section('content')
<br> <br><br>
    <section class="section pt-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <h1>{{ $product->name ?? 'Risk Assessment' }}</h1>
                    <p class="lead text-secondary">{{ $product->label ?? 'Measure exposure, prioritise action and improve operational resilience.' }}</p>
                    <p>{{ $product->description ?? 'Our assessment workflow blends data capture, analytical review and practical reporting so teams can move confidently from issue detection to action planning.' }}</p>

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
                    <img src="{{ $product?->imageUrl() ?? asset('assets/img/health/orthopedics-1.webp') }}"
                         alt="{{ $product->name ?? 'Risk assessment' }}"
                         class="img-fluid rounded shadow-sm">
                </div>
            </div>
        </div>
    </section>
@endsection
