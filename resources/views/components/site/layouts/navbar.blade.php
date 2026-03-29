<!-- header -->
<header class="site-header {{ Route::is('site.home') ? '' : 'nav-solid' }}" id="siteHeader">

    <!-- NAV -->
    <div class="nav-wrap">
        <div class="container-custom">
            <nav class="nav-pro">

                <a class="brand" href="{{ route('site.home') }}">
                    <img class="logoImg"
                        src="{{ asset($settings->getItem(app()->getLocale() == 'en' ? 'logo_en' : 'logo_ar')) }}"
                        alt="Logo">
                </a>

                <ul class="nav-links" id="navLinks">
                   

                    @php
                        $items = Cache::get('menus');
                        if ($items == null) {
                            $items = Cache::rememberForever('menus', function () {
                                return App\Models\Menue::with('trans')->orderBy('sort', 'ASC')->main()->active()->get();
                            });
                        }
                    @endphp
                    @include('site.layouts.menuItem')
                </ul>

                <div class="nav-actions">
                    <a href="{{ route('site.service_request.index') }}" class="btn-custom btn-primary-custom btn-sm active">@lang('messages.request_service')</a>
                    <div class="lang-switch d-flex align-items-center ms-lg-3">
                        @foreach ($locals as $lang)
                            @php
                                $url = LaravelLocalization::getLocalizedURL($lang);
                                $isActive = app()->getLocale() === $lang;
                            @endphp

                            {{-- <a href="{{ $url }}"
                                class="text-white d-inline-flex align-items-center me-3 {{ $isActive ? 'fw-bold text-decoration-underline' : '' }}"
                                rel="alternate" hreflang="{{ $lang }}">
                                @if ($lang == 'en')
                                    <i class="fa-solid fa-globe m-2"></i>
                                    English
                                @else
                                    <i class="fa-solid fa-language me-1"></i>
                                    عربي
                                @endif
                            </a> --}}
                        @endforeach
                    </div>

                    <button class="nav-burger" id="navBurger" aria-label="Open menu">
                        <span></span><span></span><span></span>
                    </button>
                </div>

            </nav>
        </div>
    </div>

    <style>
      .site-header {
    background: transparent;
}

.site-header.nav-solid .nav-wrap {
    background: #263E4E !important;
}
    </style>