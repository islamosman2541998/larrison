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
                <!-- Product Gallery -->
                <div class="col-lg-5">
                    <div class="product-gallery-wrapper">

                        @php
                            $galleryImages = $product->galleryGroup?->images ?? collect();
                        @endphp

                        @if ($galleryImages->count() > 0)

                            <!-- Main Image Slider -->
                            <div id="productGallerySlider" class="carousel slide product-main-slider"
                                data-bs-ride="carousel" data-bs-interval="3000" data-bs-touch="true">

                                <div class="carousel-inner">

                                    @foreach ($galleryImages as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <div class="product-main-image-box">
                                                <img src="{{ asset($image->pathInView('products')) }}"
                                                    alt="{{ $product->transNow?->title }}" class="product-main-image">
                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                                @if ($galleryImages->count() > 1)
                                    <button class="product-slider-arrow product-slider-prev" type="button"
                                        data-bs-target="#productGallerySlider" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    </button>

                                    <button class="product-slider-arrow product-slider-next" type="button"
                                        data-bs-target="#productGallerySlider" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    </button>
                                @endif

                            </div>

                            <!-- Thumbnails -->
                            @if ($galleryImages->count() > 1)
                                <div class="product-thumbs">

                                    @foreach ($galleryImages as $key => $image)
                                        <button type="button" class="product-thumb-item {{ $key == 0 ? 'active' : '' }}"
                                            data-bs-target="#productGallerySlider" data-bs-slide-to="{{ $key }}"
                                            aria-current="{{ $key == 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $key + 1 }}">
                                            <img src="{{ asset($image->pathInView('products')) }}"
                                                alt="{{ $product->transNow?->title }}">
                                        </button>
                                    @endforeach

                                </div>
                            @endif
                        @else
                            <div class="product-main-image-box">
                                <img src="{{ asset($product->pathInView()) }}" alt="{{ $product->transNow?->title }}"
                                    class="product-main-image">
                            </div>

                        @endif

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

                            @if ($product->availability)
                                <div class="meta-item">
                                    <strong>{{ __('site.availability') }}:</strong>
                                    <span>{{ $product->availability }}</span>
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
<style>
    .product-gallery-wrapper {
        width: 100%;
    }

    .product-main-slider {
        position: relative;
    }

    .product-main-image-box {
        width: 100%;
        height: 430px;
        background: #f8faf9;
        border: 1px solid #e5e7eb;
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .product-main-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 18px;
    }

    /* arrows */
    .product-slider-arrow {
        position: absolute;
        top: 50%;
        z-index: 5;
        width: 42px;
        height: 42px;
        transform: translateY(-50%);
        border: 0;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .product-slider-prev {
        left: 14px;
    }

    .product-slider-next {
        right: 14px;
    }

    .product-slider-arrow .carousel-control-prev-icon,
    .product-slider-arrow .carousel-control-next-icon {
        width: 18px;
        height: 18px;
    }

    /* thumbnails */
    .product-thumbs {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        margin-top: 14px;
        overflow: hidden;
    }

    .product-thumb-item {
        width: 100%;
        height: 76px;
        border: 2px solid transparent;
        border-radius: 14px;
        background: #f8faf9;
        padding: 6px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .product-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-thumb-item.active {
        border-color: #1c5949;
        box-shadow: 0 8px 20px rgba(28, 89, 73, 0.18);
    }

    .product-thumb-item:hover {
        border-color: #dcc27e;
    }

    @media (max-width: 768px) {
        .product-main-image-box {
            height: 340px;
            border-radius: 18px;
        }

        .product-main-image {
            padding: 12px;
        }

        .product-thumbs {
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
        }

        .product-thumb-item {
            height: 68px;
            border-radius: 12px;
        }

        .product-slider-arrow {
            width: 36px;
            height: 36px;
        }

        .product-slider-prev {
            left: 10px;
        }

        .product-slider-next {
            right: 10px;
        }
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.getElementById('productGallerySlider');

        if (!slider) return;

        const thumbs = document.querySelectorAll('.product-thumb-item');

        slider.addEventListener('slid.bs.carousel', function(event) {
            thumbs.forEach(function(thumb) {
                thumb.classList.remove('active');
                thumb.setAttribute('aria-current', 'false');
            });

            if (thumbs[event.to]) {
                thumbs[event.to].classList.add('active');
                thumbs[event.to].setAttribute('aria-current', 'true');
            }
        });
    });
</script>
