@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $show_slider = (int) $settings->getHome('show_slider');

@endphp

<!-- HERO / SWIPER -->
<section class="hero">
    <div class="swiper hero-swiper" id="heroSwiper">
        <div class="swiper-wrapper">

            @forelse ($slides as $slide)
                <div class="swiper-slide hero-slide">
                    <img src="{{ asset($slide->pathInView()) }}" alt="{{ $slide->title }}" class="hero-slide-bg">
                    <div class="hero-overlay"></div>
                    <div class="container-custom">
                        <div class="hero-content">
                            <h1>{{ $slide->title }}</h1>
                            <p class="text-white">{!! $slide->description !!}</p>
                            <div class="hero-cta">
                                <a href="{{ route('site.about-us') }}"
                                    class="btn-custom btn-primary-custom btn-sm">@lang('about.about_us')</a>
                                <a href="#" class="btn-custom btn-outline-custom btn-sm">@lang('products.view_products')</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse

        </div>

        <!-- Controls -->
        <div class="hero-controls container-custom">
            <div class="swiper-pagination"></div>
            <div class="hero-arrows">
                <button class="swiper-button-prev hero-arrow"></button>
                <button class="swiper-button-next hero-arrow"></button>
            </div>
        </div>
    </div>
</section>

</header>
<style>
    .hero-slide {
        position: relative;
    }

    .hero-slide-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 0;
    }

    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .container-custom {
        /* padding-top: 104px !important; */

    }
</style>
