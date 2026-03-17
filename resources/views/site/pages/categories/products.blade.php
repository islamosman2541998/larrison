@extends('site.app')

@section('title', $category->transNow?->meta_title ?? $category->transNow?->title)
@section('meta_description', $category->transNow?->meta_desc ?? '')
@section('meta_key', $category->transNow?->meta_key ?? '')

@section('content')

<section class="products-page py-5" id="products-page">
    <div class="container">

        <!-- Page heading -->
        <div class="products-page-head text-center mb-5 pt-5">
            <h2>{{ $category->transNow?->title }}</h2>
            <p class="products-page-subtitle">
                {{ $category->transNow?->description ? Str::limit(strip_tags($category->transNow?->description), 150) : __('site.explore_products') }}
            </p>
        </div>

        <!-- Search -->
        <div class="products-search-bar text-center mb-5">
            <form method="GET" action="{{ route('site.category.products', $category->transNow?->slug ?? $category->id) }}" class="products-search-wrap mx-auto">
                <input
                    type="text"
                    name="search"
                    class="form-control products-search-input"
                    placeholder="{{ __('site.search_products') }}..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="products-search-btn">
                    {{ __('site.search') }}
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="row g-4">

            @forelse($products as $product)
                <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                    <div class="product-page-card">
                        <div class="product-page-card__img">
                            @if($product->sale && $product->sale > 0)
                                <span class="product-page-badge sale">-{{ $product->sale }}%</span>
                            @endif
                            <img src="{{ asset($product->pathInView()) }}" alt="{{ $product->transNow?->title }}">
                        </div>

                        <div class="product-page-card__content">
                            {{-- Category name --}}
                            <span class="product-page-category">{{ $category->transNow?->title }}</span>
                            <h3>{{ $product->transNow?->title }}</h3>
                            <p>{{ Str::limit(strip_tags($product->transNow?->description), 80) }}</p>

                            <div class="product-page-bottom">
                                <a href="{{ route('site.product.show', $product->transNow?->slug ?? $product->id) }}" class="product-page-btn">
                                    {{ __('site.view_details') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-muted py-5">{{ __('site.no_products_found') }}</p>
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="products-pagination mt-5">
                <nav>
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
                </nav>
            </div>
        @endif

    </div>
</section>

@endsection