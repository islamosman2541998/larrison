<!-- OUR PARTNERS -->
@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $show_partners = (int) $settings->getHome('show_partners');
@endphp

@if ($show_partners)
    <section class="partners-section" id="partnersSection">
        <div class="container">

            <div class="partners-head text-center">
                <h3 class="partners-title">{{ __('site.our_partners') }}</h3>
            </div>

            @forelse ($partners as $partner)
                @if ($loop->first)
                    <div class="partners-slider">
                        <div class="swiper partners-swiper">
                            <div class="swiper-wrapper">
                @endif

                            <div class="swiper-slide">
                                @if ($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" rel="noopener"
                                       class="partner-card" title="{{ $partner->title }}">
                                @else
                                    <div class="partner-card">
                                @endif
                                    <img src="{{ asset('storage/attachments/partners/' . $partner->image) }}"
                                         alt="{{ $partner->title ?: __('site.our_partners') }}"
                                         loading="lazy" decoding="async">
                                @if ($partner->url)
                                    </a>
                                @else
                                    </div>
                                @endif
                            </div>

                @if ($loop->last)
                            </div>
                        </div>

                        <button type="button" class="partners-arrow partners-prev" aria-label="Previous">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M15 6l-6 6 6 6"/></svg>
                        </button>
                        <button type="button" class="partners-arrow partners-next" aria-label="Next">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg>
                        </button>
                    </div>
                @endif
            @empty
                <p class="text-center text-muted mb-0">@lang('site.no_partners')</p>
            @endforelse

        </div>
    </section>
@endif
