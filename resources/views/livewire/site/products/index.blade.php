<div>

    {{-- Search --}}
    <div class="products-search-bar text-center mb-4">
        <div class="products-search-wrap mx-auto">
            <input type="text"
                   wire:model.debounce.400ms="search"
                   class="form-control products-search-input"
                   placeholder="{{ __('site.search_products') }}...">
        </div>
    </div>

    {{-- Category filter --}}
    <div class="category-tabs-wrap text-center mb-5">
        <div class="category-tabs d-inline-flex flex-wrap justify-content-center gap-2">
            <button type="button"
                    class="category-tab {{ $selectedCategory == 0 ? 'active' : '' }}"
                    wire:click="changeCategory(0)">
                {{ __('site.all') }}
            </button>

            @foreach ($categories as $category)
                <button type="button"
                        class="category-tab {{ $selectedCategory == $category->id ? 'active' : '' }}"
                        wire:click="changeCategory({{ $category->id }})">
                    {{ $category->transNow?->title }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Grid --}}
    <div class="row g-4 products-grid" wire:loading.class="products-grid--busy">

        @forelse ($products as $product)
            @php $productCategory = $product->categories->first(); @endphp

            <div class="col-12 col-sm-6 col-lg-4 col-xl-3">
                <div class="product-page-card h-100">
                    <a href="{{ route('site.product.show', $product->routeSlug()) }}"
                       class="product-page-card__img d-block"
                       aria-label="{{ $product->transNow?->title }}">
                        @if ($product->sale && $product->sale > 0)
                            <span class="product-page-badge sale">-{{ $product->sale }}%</span>
                        @endif
                        <img src="{{ asset($product->pathInView()) }}"
                             alt="{{ $product->transNow?->title }}" loading="lazy">
                    </a>

                    <div class="product-page-card__content">
                        @if ($productCategory)
                            <span class="product-page-category">{{ $productCategory->transNow?->title }}</span>
                        @endif

                        <h3 class="product-page-name">{{ $product->transNow?->title }}</h3>

                        @if ($product->transNow?->description)
                            <p>{{ Str::limit(strip_tags($product->transNow->description), 80) }}</p>
                        @endif

                        <div class="product-page-bottom">
                            <a href="{{ route('site.product.show', $product->routeSlug()) }}"
                               class="product-page-btn">
                                {{ __('site.view_details') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="products-empty text-center">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>{{ __('site.no_products_found') }}</p>
                </div>
            </div>
        @endforelse

    </div>

</div>
