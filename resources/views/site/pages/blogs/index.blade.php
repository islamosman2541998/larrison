@extends('site.app')

@section('title', @$metaSetting->where('key', 'blogs_meta_title_' . $current_lang)->first()->value)
@section('meta_key', @$metaSetting->where('key', 'blogs_meta_key_' . $current_lang)->first()->value)
@section('meta_description', @$metaSetting->where('key', 'blogs_meta_description_' . $current_lang)->first()->value)


@section('content')




    <section class="category-page py-5 " id="category-page">
        <div class="container">

            <!-- Heading -->
            <div class="category-page-head text-center mb-5 pt-5">
                <h2>@lang('blogs.blogs')</h2>
                {{-- <p class="category-page-subtitle">Browse all Blogs and find what you need quickly.</p> --}}
            </div>


            <!-- Cards -->
            <div class="row g-4" id="categoryCards">


                @forelse ($blogs as $key =>$blog)
                    <div class="col-12 col-sm-6 col-lg-4 category-item" data-category="pharmaceuticals">
                        <div class="category-card-clean">
                            <div class="category-card-clean__img">
                                <img src="{{ asset($blog->pathInView()) }}" alt="Pharmaceuticals">
                            </div>
                            <div class="category-card-clean__content">
                                <h3>{{ $blog->title }}</h3>
                                {{-- <p>{!! Str::limit($blog->description, 200) !!}</p> --}}
                                <a href="{{ route('site.site.blogs.show', $blog->id) }}"
                                    class="category-card-link blogbtn">@lang('admin.read_more') →</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <h3>@lang('blogs.no_blogs')</h3>
                @endforelse





            </div>

        </div>
    </section>
 

@endsection
