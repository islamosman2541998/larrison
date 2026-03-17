<section class="best-sellers py-5" id="best-sellers">
  <div class="container">

    <div class="d-flex align-items-end justify-content-between gap-3 mb-4 flex-wrap">
      <div>
        <h2 class="bs-title mb-1">@lang('site.best_sellers')</h2>
        <p class="bs-subtitle mb-0">@lang('site.discover_most_popular')</p>
      </div>

      <div class="d-flex align-items-center gap-2">
      

       <button class="btn bs-nav bs-prev" type="button" aria-label="Previous">‹</button>
       <button class="btn bs-nav bs-next" type="button" aria-label="Next">›</button>
      </div>
    </div>

    <!-- Swiper -->
    <div class="swiper bs-swiper">
      <div class="swiper-wrapper">

        <!-- Slide / Product -->
        @forelse ($bestProducts as $product)
             <div class="swiper-slide">
          <div class="card bs-card h-100">
            <div class="bs-img">
            
              <img src="{{ asset($product->pathInView()) }}" class="w-100" alt="Vitamin Complex">
            </div>

            <div class="card-body">
              <h5 class="bs-name">{{ $product->transNow?->title }}</h5>
              <p class="bs-desc">  {!! Str::limit(strip_tags($product->transNow?->description), 50) !!}</p>

              <div class="d-flex align-items-center justify-content-between">
                <a href="{{ route('site.product.show', $product->transNow?->slug ?? $product->id) }}" class="btn bs-btn">@lang('button.view')</a>
              </div>
            </div>
          </div>
        </div>

        @empty
            <p class="text-center w-100">{{ __('site.no_best_sellers') }}</p>
        @endforelse
       
    

      </div>

      <div class="swiper-pagination bs-pagination mt-3"></div>
    </div>

  </div>
</section>