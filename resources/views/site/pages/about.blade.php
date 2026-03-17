@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $show_about_us = (int) $settings->getHome('show_about_us');
@endphp

<!-- ABOUT US -->
@if ($show_about_us)
   
    <!-- about -->
<section class="about-bs py-5" id="about">
  <div class="container">

    <div class="row align-items-center g-4 g-lg-5">

      <!-- Image -->
      <div class="col-12 col-lg-6">
        <div class="about-bs__image">
          <img src="{{ asset('storage/' . $about_us->image) }}" class="img-fluid" alt="Pharmaceutical & Cosmetics">
        </div>
      </div>

      <!-- Content -->
      <div class="col-12 col-lg-6">
        <div class="about-bs__content">

          <span class="about-bs__tag mb-3 d-inline-block">{{ $about_us->transNow->subtitle  }}</span>

          <h2 class="about-bs__title mb-3">
            {{ $about_us->transNow->title ?? 'About Us' }}
          </h2>

          <p class="about-bs__text mb-4">
            {!! $about_us->transNow->description ?? 'No description available' !!}
            
          </p>

          <a href="{{ route('site.about-us') }}" class="btn btn-primary about-bs__btn">
            Learn More
          </a>

        </div>
      </div>

    </div>

  </div>
</section>
@endif
