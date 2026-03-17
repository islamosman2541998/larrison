   @php
       $settings = \App\Settings\SettingSingleton::getInstance();

   @endphp
   <!-- Footer Start -->
   <div class="container-fluid bg-footer bg-primary text-white foodiv ">
       <div class="container">
           <div class="row gx-5 footerdiv">
               <div class="col-lg-8 col-md-6">
                   <div class="row gx-5">
                       <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-3" data-animate="animate__backInLeft">
                           <h4 class="text-white mb-4">@lang('admin.quicklinks')</h4>
                           <div class="d-flex flex-column justify-content-start">

                               @forelse ($footerLinks as $link)
                                   <a class="text-white mb-2"
                                       href="{{ $link->type === 'static' && $link->url ? url($link->url) : ($link->dynamic_url ? url($link->dynamic_url) : '#') }}">{{ $link->trans->where('locale', app()->getLocale())->first()->title ?? 'No Title' }}</a>

                               @empty

                                   <p>No links available</p>
                               @endforelse

                           </div>
                       </div>
                       <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-3" data-animate="animate__backInLeft">
                           <h4 class="text-white mb-4">Our categories</h4>
                           <div class="d-flex flex-column justify-content-start">
                               <a class="text-white mb-2" href="#">Pharmaceuticals</a>
                               <a class="text-white mb-2" href="#">Cosmetics</a>
                               <a class="text-white mb-2" href="#">Medical Supplies</a>
                               <a class="text-white mb-2" href="#">Baby Care</a>
                               <a class="text-white" href="#">Personal Care </a>
                           </div>
                       </div>
                       <div class="col-lg-4 col-md-12 pt-0 pt-lg-5 mb-3" data-animate="animate__backInLeft">
                           <h4 class="text-white mb-4">@lang('home.get_in_touch')</h4>
                           <div class="d-flex mb-2">
                               <i class="bi bi-geo-alt text-white me-2"></i>
                               <p class="text-white mb-0">{{ $settings->getItem('address') }}</p>
                           </div>
                           <div class="d-flex mb-2">
                               <i class="bi bi-envelope-open text-white me-2"></i>
                               <p class="text-white mb-0">{{ $settings->getItem('email') }}</p>
                           </div>
                           <div class="d-flex mb-2">
                               <i class="bi bi-telephone text-white me-2"></i>
                               <p class="text-white mb-0">{{ $settings->getItem('mobile') }}</p>
                           </div>
                           <div class="d-flex mt-4">
                               <a class="btn btn-secondary btn-square rounded-circle me-2 footericn" href="{{ $settings->getItem('twitter') }}" target="_blank"><i
                                       class="fab fa-twitter"></i></a>
                               <a class="btn btn-secondary btn-square rounded-circle me-2 footericn" href="{{ $settings->getItem('facebook') }}" target="_blank"><i
                                       class="fab fa-facebook-f"></i></a>
                               <a class="btn btn-secondary btn-square rounded-circle me-2 footericn" href="{{ $settings->getItem('linkedin') }}" target="_blank"><i
                                       class="fab fa-linkedin-in"></i></a>
                               <a class="btn btn-secondary btn-square rounded-circle footericn" href="{{ $settings->getItem('instagram') }}" target="_blank"><i
                                       class="fab fa-instagram"></i></a>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-lg-4 col-md-6 mt-lg-n5" data-animate="animate__backInLeft">
                   <div
                       class="footerbg d-flex flex-column align-items-center justify-content-center text-center bg-secondary p-5">

                       <div class="mx-auto footer-logo">
                           <a href="{{ route('site.home') }}">
                               <img src="{{ asset($settings->getItem(app()->getLocale() == 'en' ? 'logo_en' : 'logo_ar')) }}"
                                   class="imglogo">
                           </a>
                       </div>

                       <p class="pt-3 text-white"> {{ $settings->getItem('footer_description') }} </p>
                       <a href="{{ route('site.about-us') }}"
                           class="btn-sm  py-md-3 px-md-5 me-3">@lang('admin.read_more')</a>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <!-- Footer Section End -->
