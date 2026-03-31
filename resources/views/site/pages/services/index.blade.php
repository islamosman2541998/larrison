@extends('site.app')

@section('title', @$metaSetting->where('key', 'services_meta_title_' . $current_lang)->first()->value)
@section('meta_key', @$metaSetting->where('key', 'services_meta_key_' . $current_lang)->first()->value)
@section('meta_description', @$metaSetting->where('key', 'services_meta_description_' . $current_lang)->first()->value)

@section('content')



  
      <section class="services-modern py-5" id="services-page">
        <div class="container pt-5">

            <!-- heading -->
            <div class="services-modern__head text-center mb-5">
                <h1 class="services-modern__tag">Our Services</h1>
                <p class="services-modern__subtitle">
                    International sourcing, supplier qualification, private label support, regulatory documentation
                    preparation, export logistics coordination and long-term supply agreements.
                </p>
            </div>

            <!-- services grid -->
            <div class="row g-4">

                @forelse ( $services as $service )
                     <div class="col-12 col-lg-6">
                    <div class="service-card-modern h-100">
                        <div class="service-card-modern__icon">
                            <i class="fa-solid fa-leaf"></i>
                        </div>
                        <div class="service-card-modern__content">
                            <h3>{{ $service->title }}</h3>
                            <p>
                                {!! $service->description !!}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                    <p>No services available.</p>
                @endforelse
               

          
            </div>



        </div>
    </section>






@endsection
