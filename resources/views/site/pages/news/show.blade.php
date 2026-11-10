@extends('site.app')

@section('title', @$news->meta_title  )
@section('meta_key', @$news->meta_key )
@section('meta_description', @$news->meta_description )


@section('content')
@include('site.partials.breadcrumb', [
    'items' => [
        ['label' => __('site.news'), 'url' => route('site.news.index')],
        ['label' => $news->title],
    ],
])

<div class="container py-5" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

 
    <div class="row">
        <div class="col-md-12 d-flex flex-column align-items-center">
            @if($news->image)
                <img src="{{ asset($news->image) }}"
                     class="img-thumbnail w-50" alt="{{ $news->title }}">
            @endif

         
        </div>
        <div class="col-md-12 mt-5 fs-5 d-flex flex-column align-items-center">
               <h1 class="mb-3 text-dark">{{ $news->title }}</h1>
            <div class="blog-description">
                {!! $news->description !!}
            </div>
        </div>
    </div>
</div>
@endsection
