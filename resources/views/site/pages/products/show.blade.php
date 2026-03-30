@extends('site.app')

@section('title', $product->transNow?->meta_title ?? $product->transNow?->title)
@section('meta_description', $product->transNow?->meta_desc ?? '')
@section('meta_key', $product->transNow?->meta_key ?? '')

@section('content')

    <section class="product-details-page py-5" id="product-details-page">
        <div class="container">

            <!-- Breadcrumb -->
            <div class="product-breadcrumb mb-4">
                <a href="{{ route('site.home') }}">{{ __('site.home') }}</a>
                <span>/</span>

                @if ($parentCategory)
                    <a href="{{ route('site.parent.categories', $parentCategory->transNow?->slug ?? $parentCategory->id) }}">
                        {{ $parentCategory->transNow?->title }}
                    </a>
                    <span>/</span>
                @endif

                @if ($category)
                    <a href="{{ route('site.category.products', $category->transNow?->slug ?? $category->id) }}">
                        {{ $category->transNow?->title }}
                    </a>
                    <span>/</span>
                @endif

                <span class="current">{{ $product->transNow?->title }}</span>
            </div>

            <!-- Main Product Details -->
            <div class="row g-5 align-items-center">

                <!-- Product Image -->
                <div class="col-lg-5">
                    <div class="product-details-image">
                        <img src="{{ asset($product->pathInView()) }}" alt="{{ $product->transNow?->title }}"
                            class="img-fluid">
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-7">
                    <div class="product-details-content">

                        <h1 class="product-details-title">{{ $product->transNow?->title }}</h1>
                        @if ($product->code)
                            <h6>SKU: {{ $product->code }}</h6>
                        @endif

                        <p class="product-details-text">
                            {!! $product->transNow?->description !!}
                        </p>

                        <div class="product-details-meta">

                            {{-- Category = Parent Category --}}
                            @if ($parentCategory)
                                <div class="meta-item">
                                    <strong>{{ __('site.category') }}:</strong>
                                    <span>{{ $parentCategory->transNow?->title }}</span>
                                </div>
                            @endif

                            {{-- Type = Product Category --}}
                            @if ($category)
                                <div class="meta-item">
                                    <strong>{{ __('site.type') }}:</strong>
                                    <span>{{ $category->transNow?->title }}</span>
                                </div>
                            @endif

                            @if ($product->code)
                                <div class="meta-item">
                                    <strong>{{ __('site.availability') }}:</strong>
                                    <span>{{ $product->code }}</span>
                                </div>
                            @endif

                        </div>

                        <div class="product-details-actions">
                            <a href="{{ route('site.contact-us') }}" class="btn product-main-btn">
                                {{ __('site.request_product') }}
                            </a>

                            @if ($category)
                                <a href="{{ route('site.category.products', $category->transNow?->slug ?? $category->id) }}"
                                    class="btn product-outline-btn">
                                    {{ __('site.back_to_products') }}
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            <!-- Additional Info (Product Tips) -->
            @if ($product->tipsActive && $product->tipsActive->count() > 0)
                <div class="row g-4 mt-5">

                    @foreach ($product->tipsActive as $tip)
                        <div class="col-lg-4">
                            <div class="product-info-box h-100">
                                <h3>{{ $tip->transNow?->title }}</h3>
                                {!! $tip->transNow?->description !!}
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="related-products-section mt-5">
                    <h2 class="related-products-title text-center mb-4">{{ __('site.related_products') }}</h2>
                    <div class="row g-4">

                        @foreach ($relatedProducts as $relProduct)
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div class="sub-card-bs">
                                    <div class="sub-img-bs">
                                        <img src="{{ asset($relProduct->pathInView()) }}"
                                            alt="{{ $relProduct->transNow?->title }}">
                                    </div>
                                    <div class="sub-body-bs">
                                        <h3>{{ $relProduct->transNow?->title }}</h3>

                                        <p>{{ Str::limit(strip_tags($relProduct->transNow?->description), 50) }}</p>
                                        <a href="{{ route('site.product.show', $relProduct->transNow?->slug ?? $relProduct->id) }}"
                                            class="sub-more-bs">
                                            {{ __('site.see_more') }} →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

        </div>
    </section>

@endsection
