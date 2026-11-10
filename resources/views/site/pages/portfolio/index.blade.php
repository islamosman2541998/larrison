@extends('site.app') 

@section('content')

    @include('site.partials.breadcrumb', [
        'items' => [
            ['label' => __('site.portfolio')],
        ],
    ])

    <!-- Portfolio Section -->
    <section class="portfolio spad">
        <div class="container">
            <livewire:site.portfolio-gallery />
        </div>
    </section>
<style>
    .portfolio {
    padding-top: 0px !important;
    padding-bottom: 100px;
}
  
</style>
@endsection
