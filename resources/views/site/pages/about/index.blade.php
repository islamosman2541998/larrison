@extends('site.app')

@section('title', @$metaSetting->where('key', 'about_meta_title_' . $current_lang)->first()->value)
@section('meta_key', @$metaSetting->where('key', 'about_meta_key_' . $current_lang)->first()->value)
@section('meta_description', @$metaSetting->where('key', 'about_meta_description_' . $current_lang)->first()->value)

@section('content')
   
    
   

   

    <!-- about -->
  <section class="about-bs py-5 " id="about">
    <div class="container">

      <div class="row align-items-center g-4 g-lg-5 pt-5">

        <!-- Image -->
        <div class="col-12 col-lg-6 pt-3">
          <div class="about-bs__image ">
            <img src="{{ asset('storage/' . $about->image) }}" class="img-fluid" alt="Pharmaceutical & Cosmetics">
          </div>
        </div>

        <!-- Content -->
        <div class="col-12 col-lg-6 pt-3">
          <div class="about-bs__content">

            <span class="about-bs__tag mb-3 d-inline-block">{{ $about->subtitle }}</span>

            <h2 class="about-bs__title mb-3">
             {{ $about->title }}
            </h2>

            <p class="about-bs__text mb-4">
              {!! $about->description !!}
            </p>


          



          </div>
        </div>

      </div>

    </div>
  </section>
  <!-- our vission -->
  <section class="vision-mission" style="padding-bottom: 4rem; padding-top: 1.5rem;">
    <div class="container">

      <div class="section-heading text-center mb-5">
        <h4>@lang('about.Vision_Mission')</h4>
        <p>
          @lang('about.at_hulul')
        </p>
      </div>

      <div class="row g-4 justify-content-center">

        <!-- Vision -->
        <div class="col-12 col-lg-6">
          <div class="vm-card text-center h-100">
            <div class="vm-icon">
              <i class="fa-solid fa-eye"></i>
            </div>

            <h3>@lang('about.vision')</h3>

            <p>
              {!! $about->transNow->vision ?? 'No description available' !!}
            </p>
          </div>
        </div>

        <!-- Mission -->
        <div class="col-12 col-lg-6">
          <div class="vm-card text-center h-100">
            <div class="vm-icon">
              <i class="fa-solid fa-hand-holding-medical"></i>
            </div>

            <h3>@lang('about.mission')</h3>

            <p>
              {!! $about->transNow->mission ?? 'No description available' !!}
            </p>
          </div>
        </div>

      </div>

    </div>
  </section>

@endsection

