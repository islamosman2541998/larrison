@extends('site.app')

@section('title', @$metaSetting->where('key', 'product_meta_title_' . $current_lang)->first()->value ?? __('messages.Our Products'))
@section('meta_key', @$metaSetting->where('key', 'product_meta_key_' . $current_lang)->first()->value ?? '')
@section('meta_description', @$metaSetting->where('key', 'product_meta_description_' . $current_lang)->first()->value ?? '')

@section('content')

<section class="products-page py-5" id="products-page">
    <div class="container pt-5">

        <!-- Heading -->
        <div class="products-page-head text-center mb-5 pt-5">
            <span class="products-page-tag">{{ __('site.all_categories') }}</span>
            <h1 class="products-page-title">{{ __('messages.Our Products') }}</h1>
            <p class="products-page-subtitle">{{ __('site.browse_products') }}</p>
        </div>

        @livewire('site.products.index', ['categories' => $categories])

    </div>
</section>

@endsection
