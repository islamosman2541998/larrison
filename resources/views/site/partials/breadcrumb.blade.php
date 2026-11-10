@php
    $breadcrumbItems = $items ?? [];
@endphp

<nav class="site-breadcrumb-shell" aria-label="{{ __('site.breadcrumb') }}">
    <div class="container">
        <ol class="site-breadcrumb-list">
            <li>
                <a href="{{ route('site.home') }}">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                    <span>{{ __('site.home') }}</span>
                </a>
            </li>

            @foreach ($breadcrumbItems as $item)
                <li @if ($loop->last) class="current" aria-current="page" @endif>
                    @if (!empty($item['url']) && !$loop->last)
                        <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
                    @else
                        <span>{{ $item['label'] }}</span>
                    @endif
                </li>
            @endforeach
        </ol>
    </div>
</nav>
