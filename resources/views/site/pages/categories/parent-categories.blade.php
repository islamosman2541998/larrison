@extends('site.app')

@section('title', $parentCategory->transNow?->meta_title ?? $parentCategory->transNow?->title)
@section('meta_description', $parentCategory->transNow?->meta_desc ?? '')
@section('meta_key', $parentCategory->transNow?->meta_key ?? '')

@section('content')

<section class="products-page py-5" id="products-page">
    <div class="container">

        <!-- Page heading -->
        <div class="products-page-head text-center mb-5 pt-5">
            <h2>{{ $parentCategory->transNow?->title }}</h2>
            <p class="products-page-subtitle">
                {{ $parentCategory->transNow?->description ? Str::limit(strip_tags($parentCategory->transNow?->description), 150) : __('site.explore_categories') }}
            </p>
        </div>

        <!-- Search -->
        <div class="products-search-bar text-center mb-5">
            <form method="GET" action="{{ route('site.parent.categories', $parentCategory->transNow?->slug ?? $parentCategory->id) }}" class="products-search-wrap mx-auto">
                <input
                    type="text"
                    name="search"
                    class="form-control products-search-input"
                    placeholder="{{ __('site.search_categories') }}..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="products-search-btn">
                    {{ __('site.search') }}
                </button>
            </form>
        </div>

        <!-- Categories Grid -->
        <div class="row g-4">

            @forelse($categories as $subCat)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="product-page-card">
                        <div class="product-page-card__img">
                            <img src="{{ asset($subCat->pathInView()) }}" alt="{{ $subCat->transNow?->title }}">
                        </div>

                        <div class="product-page-card__content">
                            <span class="product-page-category">{{ $parentCategory->transNow?->title }}</span>
                            <h3>{{ $subCat->transNow?->title }}</h3>
                            <p>{{ Str::limit(strip_tags($subCat->transNow?->description), 80) }}</p>

                            <div class="product-page-bottom">
                                <a href="{{ route('site.category.products', $subCat->transNow?->slug ?? $subCat->id) }}" class="product-page-btn">
                                    {{ __('site.view_products') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted py-5">{{ __('site.no_categories_found') }}</p>
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($categories->hasPages())
            <div class="products-pagination mt-5">
                <nav>
                    {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @endif

    </div>
</section>

@endsection