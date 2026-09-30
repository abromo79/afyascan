@extends('layouts.app')

@section('content')
<br><br>
<section class="page-title section pt-9">
    <div class="container text-center">

        <span class="text-primary fw-semibold">
            {{ $post->category?->name ?? 'AfyaScan Insights' }}
        </span>

        <h1 class="mt-3">
            {{ $post->title }}
        </h1>

        <p class="lead text-secondary mb-0">
            {{ $post->excerpt }}
        </p>

        <div class="mt-3 text-secondary">
            <small>
                By {{ $post->author?->name ?? 'AfyaScan' }}
                @if ($post->published_at)
                    &bull; {{ $post->published_at->format('F d, Y') }}
                @endif
            </small>
        </div>

    </div>
</section>


<section class="section pt-4">
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-9">

                {{-- Featured Image --}}
                @if ($post->featured_image)
                    <div class="mb-5">
                        <img src="{{ $post->featuredImageUrl() }}"
                             class="img-fluid rounded shadow-sm w-100"
                             alt="{{ $post->title }}">
                    </div>
                @endif


                {{-- Article Content --}}
                <article class="blog-content">

                    {!! $post->content !!}

                </article>


                {{-- Medical / AI Disclaimer --}}
                <div class="alert alert-light border mt-5">
                    <strong>Important:</strong>
                    AfyaScan's health technology content is intended for
                    educational and informational purposes. It does not replace
                    professional medical advice, diagnosis or treatment.
                </div>


                {{-- Back to Blog --}}
                <div class="mt-4">
                    <a href="{{ route('blog') }}"
                       class="btn btn-primary">
                        &larr; Back to Blog
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>
</div>
@endsection
