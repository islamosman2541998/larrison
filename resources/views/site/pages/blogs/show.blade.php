@extends('site.app')

@section('title', @$blog->transNow->meta_title  )
@section('meta_key', @$blog->transNow->meta_key )
@section('meta_description', @$blog->transNow->meta_description )


@section('content')
    @include('site.partials.breadcrumb', [
        'items' => [
            ['label' => __('site.blogs'), 'url' => route('site.site.blogs.index')],
            ['label' => $blog->transNow?->title],
        ],
    ])

    <!-- Blog Section Begin -->
  <div class="container">
      <h1 class="text-dark theH1 mt-5">{{ @$blog->transNow->title }}</h1>
    </div>

  <main class="container">
    <figure class="cover">
      <img src="{{ asset(@$blog->pathInView()) }}" class="blogImg" alt="Share a Video on Social Media">
    </figure>

         <p class="single-meta">{!!  @$blog->transNow->description !!} </p>

  </main>
    <!-- Blog Section End -->

@endsection
