@extends('site.app')

@section('title', __('site.our_categories'))

@section('content')

<section class="category-page py-5" id="category-page">
    <div class="container">

        <!-- Heading -->
        <div class="category-page-head text-center mb-5 pt-5">
            <h2>{{ __('site.our_categories') }}</h2>
            <p class="category-page-subtitle">{{ __('site.browse_categories') }}</p>

            <div class="category-search mx-auto mt-4">
                <input type="text" id="categorySearch" class="form-control" placeholder="{{ __('site.search_category') }}...">
            </div>
        </div>

        <!-- Tabs (Parent Categories) -->
        <div class="category-tabs-wrap text-center mb-5">
            <div class="category-tabs d-inline-flex flex-wrap justify-content-center gap-2" id="categoryTabs">
                <button class="category-tab active" data-tab="all">{{ __('site.all_categories') }}</button>
                @foreach($parentCategories as $parent)
                    <button class="category-tab" data-tab="parent-{{ $parent->id }}">
                        {{ $parent->transNow?->title }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Cards (Product Categories) -->
        <div class="row g-4" id="categoryCards">

            @foreach($parentCategories as $parent)
                @foreach($parent->productCategories as $subCat)
                    <div class="col-12 col-sm-6 col-lg-4 category-item" data-category="parent-{{ $parent->id }}">
                        <div class="category-card-clean">
                            <div class="category-card-clean__img">
                                <img src="{{ asset($subCat->pathInView()) }}" alt="{{ $subCat->transNow?->title }}">
                            </div>
                            <div class="category-card-clean__content">
                                <h3>{{ $subCat->transNow?->title }}</h3>
                                <p>{{ Str::limit(strip_tags($subCat->transNow?->description), 80) }}</p>
                                <a href="{{ route('site.category.products', $subCat->transNow?->slug ?? $subCat->id) }}" class="category-card-link">
                                    {{ __('site.view_products') }} →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach

        </div>

    </div>
</section>

@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.category-tab');
    const cards = document.querySelectorAll('.category-item');
    const searchInput = document.getElementById('categorySearch');

    // Tab filtering
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
            filterCards();
        });
    });

    // Search filtering
    searchInput.addEventListener('input', function () {
        filterCards();
    });

    function filterCards() {
        const activeTab = document.querySelector('.category-tab.active').getAttribute('data-tab');
        const searchVal = searchInput.value.toLowerCase().trim();

        cards.forEach(function (card) {
            const cardCategory = card.getAttribute('data-category');
            const cardTitle = card.querySelector('h3').textContent.toLowerCase();
            const cardDesc = card.querySelector('p').textContent.toLowerCase();

            const matchesTab = (activeTab === 'all') || (cardCategory === activeTab);
            const matchesSearch = !searchVal || cardTitle.includes(searchVal) || cardDesc.includes(searchVal);

            card.style.display = (matchesTab && matchesSearch) ? '' : 'none';
        });
    }
});
</script>
@endsection