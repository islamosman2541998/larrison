@extends('site.app')

@section('title', @$metaSetting->where('key', 'news_meta_title_' . $current_lang)->first()->value)
@section('meta_key', @$metaSetting->where('key', 'news_meta_key_' . $current_lang)->first()->value)
@section('meta_description', @$metaSetting->where('key', 'news_meta_description_' . $current_lang)->first()->value)


@section('content')

<section class="news-page pt-5 pb-5" id="news-page">
    <div class="container">
        
        {{-- Page Head --}}
        <div class="text-center mb-5 pt-5">
            <h1 class="news-title text-dark fw-bold">News & Insights</h1>
            <p class="news-subtitle text-muted mx-auto" style="max-width: 600px;">
                Stay updated with our latest news, healthcare insights, product
                updates, and company announcements.
            </p>
        </div>

        {{-- News Grid --}}
        <div class="row g-4">
            @forelse ($news as $new)
                <div class="col-md-4">
                    <div class="news-card h-100 rounded-3 overflow-hidden shadow-sm">
                        
                        {{-- Image --}}
                        <div class="news-card-img">
                            <img src="{{ asset($new->image) }}" alt="{{ $new->title }}" />
                        </div>

                        {{-- Content --}}
                        <div class="news-card-content p-3">
                            <h5 class="fw-bold mb-2">{{ $new->title }}</h5>
                            <p class="text-muted small mb-3">
                                {!! Str::limit(strip_tags($new->description), 120) !!}
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">
                                    <i class="fa-regular fa-calendar me-1"></i>
                                    {{ $new->created_at->format('d M Y') }}
                                </span>
                                <a href="{{ route('site.news.show', $new->id) }}" class="news-link">
                                    @lang('site.read_more') →
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <h5 class="text-muted">@lang('site.no_news')</h5>
                </div>
            @endforelse
        </div>

    </div>
</section>
@endsection

<style>
.news-card {
    background: #fff;
    border: 1px solid #eee;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.news-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12) !important;
}

.news-card-img {
    width: 100%;
    height: 220px;
    overflow: hidden;
}

.news-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.news-card:hover .news-card-img img {
    transform: scale(1.05);
}

.news-link {
    color: #0d6efd;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.875rem;
    transition: color 0.2s ease;
}

.news-link:hover {
    color: #0a58ca;
    text-decoration: underline;
}
</style>
