{{-- Reviews --}}

@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $show_reviews = (int) $settings->getHome('show_reviews');
@endphp
@if ($show_reviews)

    {{-- Reviews --}}




    <!-- testminiol -->
    <section class="testi py-5" id="testimonials">
        <div class="container">

            <!-- Head -->
            <div class="d-flex align-items-end justify-content-between gap-3 mb-4 flex-wrap">
                <div>
                    <h2 class="testi-title mb-1">@lang('reviews.what_clients_say')</h2>
                </div>

                <div class="d-flex align-items-center gap-2" style="gap: 10px;">
                    <button class="btn testi-nav testi-prev" type="button" aria-label="Previous">‹</button>
                    <button class="btn testi-nav testi-next" type="button" aria-label="Next">›</button>
                </div>
            </div>

            <!-- Swiper -->
            <div class="testi-wrap">
                <div class="swiper testi-swiper">
                    <div class="swiper-wrapper">

                        @forelse ($reviews as $review)
                            <div class="swiper-slide">
                                <div class="card testi-card h-100">
                                    <div class="card-body">
                                        <div class="testi-top d-flex align-items-center justify-content-between mb-3">
                                            <div class="d-flex align-items-center gap-3" style="gap: 10px;">
                                                <div class="testi-avatar">
                                                    {{ mb_strtoupper(mb_substr($review->customer_name, 0, 2)) }}</div>
                                                <div>
                                                    <h6 class="testi-name mb-0">{{ $review->customer_name }}</h6>
                                                </div>
                                            </div>
                                            <div class="testi-stars" aria-label="5 stars">★★★★★</div>
                                        </div>

                                        <p class="testi-text mb-0">
                                            {!! $review->description !!}
                                        </p>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <p>No reviews available</p>
                        @endforelse

                    </div>

                    <div class="swiper-pagination testi-pagination mt-4"></div>
                </div>
            </div>

        </div>
    </section>
@endif
