@extends('site.app')

@section('title', @$metaSetting->where('key', 'home_meta_title_' . $current_lang)->first()->value)
@section('meta_key', @$metaSetting->where('key', 'home_meta_key_' . $current_lang)->first()->value)
@section('meta_description', @$metaSetting->where('key', 'home_meta_description_' . $current_lang)->first()->value)


@section('content')

    <!-- Slider -->
    <x-slider />

    <!-- About us -->
    @include('site.pages.about')

    <!-- Categories -->

    <livewire:site.categories-section />

    <!-- Best Sellers -->
    @include('site.pages.bestproducts')




    <!-- Reviews -->
    <x-reviews />

    <!-- Faq -->
    @include('site.pages.faq_questions')

    <!-- Partners -->
    @include('site.pages.partners')

@endsection
