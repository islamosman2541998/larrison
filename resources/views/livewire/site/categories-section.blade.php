<section class="cats-bs py-5" id="categories">
    <div class="container">

        <!-- Head -->
        <div class="text-center mb-4">
            <h2 class="cats-title">{{ __('site.our_product_categories') }}</h2>
            <p class="cats-subtitle">{{ __('site.choose_category') }}</p>
        </div>

        <!-- Parent Category Tabs -->
        <ul class="nav nav-pills justify-content-center gap-2 cats-nav mb-4" role="tablist">
             {{-- All Categories --}}
        <li class="nav-item" role="presentation">
            <button wire:click="selectParent('all')" class="nav-link {{ $activeParentId == 'all' ? 'active' : '' }}"
                type="button">
                {{ __('site.all_categories') }}
            </button>
        </li>
            @foreach ($parentCategories as $parent)
                <li class="nav-item" role="presentation">
                    <button wire:click="selectParent({{ $parent->id }})"
                        class="nav-link {{ $activeParentId == $parent->id ? 'active' : '' }}" type="button"
                        role="tab">
                        {{ optional($parent->transNow)->title }}
                    </button>
                </li>
            @endforeach
        </ul>
       
        <!-- Sub Categories Cards -->
        <div wire:loading.class="opacity-50" style="transition: opacity 0.3s ease;">

            @if (count($subCategories) > 0)
                <div class="row g-4">

                    @foreach ($subCategories as $subCat)
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="sub-card-bs">
                                <div class="sub-img-bs">
                                    <img src="{{ asset($subCat->pathInView()) }}"
                                        alt="{{ optional($subCat->transNow)->title }}">
                                </div>
                                <div class="sub-body-bs">
                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                        <h3>{{ optional($subCat->transNow)->title }}</h3>
                                        @if ($subCat->code)
                                            <p>Code: {{ $subCat->code }}</p>
                                        @endif
                                    </div>
                                    <p>{{ Str::limit(strip_tags(optional($subCat->transNow)->description), 50) }}</p>

                                    <a href="{{ route('site.category.products', optional($subCat->transNow)->slug ?? $subCat->id) }}"
                                        class="sub-more-bs">
                                        {{ __('site.see_more') }} →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                @php
                    $activeParent = $parentCategories->find($activeParentId);
                @endphp
                @if ($activeParent)
                    <div class="text-center mt-4">
                        <a href="{{ route('site.parent.categories', optional($activeParent->transNow)->slug ?? $activeParent->id) }}"
                            class="btn btn-primary cats-cta">
                            {{ __('site.see_all') }} {{ optional($activeParent->transNow)->title }}
                        </a>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <p class="text-muted">{{ __('site.no_categories_found') }}</p>
                </div>
            @endif

        </div>

    </div>
</section>

<style>
    /* Section */
    .cats-bs {
        background: #f8fafb;
    }

    .cats-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a2332;
        margin-bottom: 0.5rem;
    }

    .cats-subtitle {
        font-size: 1rem;
        color: #6b7c93;
        margin-bottom: 0;
    }

    /* Nav Pills (Parent Category Tabs) */
    .cats-nav .nav-link {
        border-radius: 50px;
        padding: 0.55rem 1.5rem;
        font-size: 0.95rem;
        font-weight: 500;
        color: #3a4a5c;
        background: #fff;
        border: 1.5px solid #d6dce4;
        transition: all 0.3s ease;
    }

    .cats-nav .nav-link:hover {
        color: #fff;
        background: #3a8d8c;
        border-color: #3a8d8c;
    }

    .cats-nav .nav-link.active {
        color: #fff;
        background: #3a8d8c;
        border-color: #3a8d8c;
        box-shadow: 0 4px 12px rgba(58, 141, 140, 0.3);
    }

    /* Sub Category Cards */
    .sub-card-bs {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.35s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .sub-card-bs:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .sub-img-bs {
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .sub-img-bs img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .sub-card-bs:hover .sub-img-bs img {
        transform: scale(1.08);
    }

    .sub-body-bs {
        padding: 1.2rem 1rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .sub-body-bs h3 {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a2332;
        margin-bottom: 0.4rem;
    }

    .sub-body-bs p {
        font-size: 0.88rem;
        color: #6b7c93;
        margin-bottom: 0.8rem;
        /* flex: 1; */
    }

    .sub-more-bs {
        font-size: 0.9rem;
        font-weight: 600;
        color: #3a8d8c;
        text-decoration: none;
        transition: color 0.25s ease;
    }

    .sub-more-bs:hover {
        color: #2c6e6d;
    }

    /* See All Button */
    .cats-cta {
        background: #3a8d8c;
        border-color: #3a8d8c;
        border-radius: 50px;
        padding: 0.6rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .cats-cta:hover {
        background: #2c6e6d;
        border-color: #2c6e6d;
        box-shadow: 0 4px 15px rgba(58, 141, 140, 0.35);
    }

    /* Loading state */
    .opacity-50 {
        opacity: 0.5;
    }

    /* RTL Support */
    [dir="rtl"] .sub-more-bs {
        direction: rtl;
    }

    [dir="rtl"] .cats-nav {
        direction: rtl;
    }

    /* Responsive */
    @media (max-width: 767px) {
        .cats-title {
            font-size: 1.6rem;
        }

        .cats-nav {
            flex-wrap: nowrap;
            overflow-x: auto;
            justify-content: flex-start !important;
            padding-bottom: 0.5rem;
            -webkit-overflow-scrolling: touch;
        }

        .cats-nav .nav-link {
            white-space: nowrap;
            font-size: 0.85rem;
            padding: 0.45rem 1.1rem;
        }

        .sub-img-bs {
            height: 160px;
        }
    }
</style>
