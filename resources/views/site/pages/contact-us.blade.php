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
        <div class="contact-page-head text-center mb-5">
            <h1 class="contact-title">@lang('home.contact-us')</h1>
            
        </div>

        <!-- Top Info Cards -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="contact-info-card h-100 text-center">
                    <div class="contact-info-icon">
                        <i class="fa-solid fa-phone"></i>
                    </div>
                    <h3>@lang('admin.phone')</h3>
                    <a href="tel:{{ $settings->getItem('mobile') }}">{{ $settings->getItem('mobile') }}</a>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="contact-info-card h-100 text-center">
                    <div class="contact-info-icon">
                        <i class="fa-solid fa-envelope"></i>
                    </div>
                    <h3>@lang('admin.email')</h3>
                    <a href="mailto:{{ $settings->getItem('email') }}">{{ $settings->getItem('email') }}</a>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-4">
                <div class="contact-info-card h-100 text-center">
                    <div class="contact-info-icon">
                        <i class="fa-solid fa-location-dot"></i>
                    </div>
                    <h3>@lang('admin.address')</h3>
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
                        <h2>@lang('site.love_to_hear')</h2>
                        <p>@lang('site.contact_side_desc')</p>

                       

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
                                <label class="form-label">@lang('contact_us.name')</label>
                                <input type="text" name="name" class="form-control contact-input"
                                       placeholder="@lang('site.enter_name')"
                                       value="{{ old('name') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('contact_us.phone')</label>
                                <input type="text" name="phone" class="form-control contact-input"
                                       placeholder="@lang('site.enter_phone')"
                                       value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('contact_us.email')</label>
                                <input type="email" name="email" class="form-control contact-input"
                                       placeholder="@lang('site.enter_email')"
                                       value="{{ old('email') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">@lang('site.subject')</label>
                                <input type="text" name="subject" class="form-control contact-input"
                                       placeholder="@lang('site.enter_subject')"
                                       value="{{ old('subject') }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">@lang('contact_us.message')</label>
                                <textarea name="message" class="form-control contact-input contact-textarea"
                                          rows="6"
                                          placeholder="@lang('site.write_message')">{{ old('message') }}</textarea>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit" class="btn contact-btn">
                                    @lang('site.send_message')
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