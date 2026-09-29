@extends('site.app')
@section('title', @$metaSetting->where('key', 'contact_us_meta_title_' . $current_lang)->first()->value ?? __('site.contact_us'))
@section('meta_key', @$metaSetting->where('key', 'contact_us_meta_key_' . $current_lang)->first()->value ?? '')
@section('meta_description', @$metaSetting->where('key', 'contact_us_meta_description_' . $current_lang)->first()->value ?? '')

@php
    $settings = \App\Settings\SettingSingleton::getInstance();
@endphp

@section('content')

<section class="contact-page py-5" id="contact-page">
    <div class="container pt-5">

        <!-- Heading -->
        {{-- All texts below are editable from: Dashboard > Settings > Page sections > Contact page --}}
        <div class="contact-page-head text-center mb-5">
            <h1 class="contact-title">{{ page_text('contact.hero.title') }}</h1>
            @if (page_text('contact.hero.subtitle'))
                <p class="contact-subtitle">{{ page_text('contact.hero.subtitle') }}</p>
            @endif
        </div>

        <!-- Top Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="contact-info-card h-100 text-center">
                    <div class="contact-info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h3>{{ page_text('contact.info_cards.phone') }}</h3>
                    <a href="tel:{{ $settings->getItem('mobile') }}">{{ $settings->getItem('mobile') }}</a>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="contact-info-card h-100 text-center">
                    <div class="contact-info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h3>{{ page_text('contact.info_cards.email') }}</h3>
                    <a href="mailto:{{ $settings->getItem('email') }}">{{ $settings->getItem('email') }}</a>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="contact-info-card h-100 text-center">
                    <div class="contact-info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3>{{ page_text('contact.info_cards.address') }}</h3>
                    <span>{{ $settings->getItem('address') }}</span>
                </div>
            </div>
        </div>

        <!-- Main Contact Area -->
        <div class="contact-main-box">
            <div class="row g-4 align-items-stretch">

                <!-- Left Side -->
                <div class="col-lg-5">
                    <div class="contact-side h-100">
                      <a href="{{ route('site.home') }}">
                               <img src="{{ asset($settings->getItem(app()->getLocale() == 'en' ? 'logo_en' : 'logo_ar')) }}"
                                   class="imglogo">
                           </a>
                        {{-- <span class="contact-side-tag">@lang('site.lets_talk')</span> --}}
                        {{-- No default text for these two: left empty in the
                             dashboard, nothing is rendered in their place. --}}
                        @if (page_text('contact.side.title'))
                            <h2>{{ page_text('contact.side.title') }}</h2>
                        @endif

                        @if (page_text('contact.side.description'))
                            <p>{{ page_text('contact.side.description') }}</p>
                        @endif

                       

                        {{-- <div class="contact-side-box">
                            <h4>@lang('site.working_hours')</h4>
                            <p>{{ $settings->getItem('working_hours') ?? __('site.default_working_hours') }}</p>
                        </div> --}}
                    </div>
                </div>

                <!-- Right Form -->
                <div class="col-lg-7">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form class="contact-form" method="POST" action="{{ route('site.contact.store') }}">
                        @csrf
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">{{ page_text('contact.form.name_label') }}</label>
                                <input type="text" name="name" class="form-control contact-input"
                                       placeholder="{{ page_text('contact.form.name_placeholder') }}"
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ page_text('contact.form.phone_label') }}</label>
                                <input type="text" name="phone" class="form-control contact-input"
                                       placeholder="{{ page_text('contact.form.phone_placeholder') }}"
                                       value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ page_text('contact.form.email_label') }}</label>
                                <input type="email" name="email" class="form-control contact-input"
                                       placeholder="{{ page_text('contact.form.email_placeholder') }}"
                                       value="{{ old('email') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">{{ page_text('contact.form.subject_label') }}</label>
                                <input type="text" name="subject" class="form-control contact-input"
                                       placeholder="{{ page_text('contact.form.subject_placeholder') }}"
                                       value="{{ old('subject') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">{{ page_text('contact.form.message_label') }}</label>
                                <textarea name="message" class="form-control contact-input contact-textarea"
                                          rows="6"
                                          placeholder="{{ page_text('contact.form.message_placeholder') }}">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn contact-btn">
                                    {{ page_text('contact.form.button') }}
                                </button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>

        <!-- Map -->
        @if($settings->getItem('maps'))
            <div class="contact-map-box mt-5">
                <iframe
                    src="{{ $settings->getItem('maps') }}"
                    width="100%"
                    height="420"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        @endif

    </div>
</section>

@endsection