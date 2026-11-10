@extends('site.app')

@section('title', @$metaSetting->where('key', 'faq_meta_title_' . $current_lang)->first()->value)
@section('meta_key', @$metaSetting->where('key', 'faq_meta_key_' . $current_lang)->first()->value)
@section('meta_description', @$metaSetting->where('key', 'faq_meta_description_' . $current_lang)->first()->value)

@section('content')
    @include('site.partials.breadcrumb', [
        'items' => [
            ['label' => __('site.faq')],
        ],
    ])

    <!-- ===== HERO ===== -->
    <section class="hero wow bounceInLeft" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
        <div class="container">
            <h1 class="color_blue">@lang('home.faq-index')</h1>
        </div>
    </section>

    @livewire('site.faq.index', ['categories' => $categories], key($user->id))


@endsection
