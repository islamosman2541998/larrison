 <!-- FAQ Section--------------------------------- -->
 @php
     $settings = \App\Settings\SettingSingleton::getInstance();
     $show_faq = (int) $settings->getHome('show_faq');
 @endphp
 @if ($show_faq)
 

     <!-- faq -->
     <section class="faq py-5" id="faq">
         <div class="container">

             <div class="faq-head text-center mb-5">
                 <h2 class="faq-title">@lang('home.faq_title')</h2>
                 <p class="faq-subtitle">@lang('home.faq')</p>
             </div>

             <div class="faq-wrapper">

                 @forelse ($faq_questions as $key => $question)
                     <!-- Item -->
                     <div class="faq-item ">
                         <div class="faq-question">
                             {{ $question->question }}
                             <span class="faq-icon">⌄</span>
                         </div>
                         <div class="faq-answer ">
							<p class="faq-ans"> {!! $question->answer !!}</p>
                         </div>
                     </div>

                 @empty
                     <p>@lang('home.no_faq')</p>
                 @endforelse



             </div>

         </div>
     </section>
 @endif
<style>
.faq-answer p{
color: black !important;
	} 	
</style>