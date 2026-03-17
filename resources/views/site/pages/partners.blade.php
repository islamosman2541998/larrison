<!-- OUR PARTNERS -->
@php
    $settings = \App\Settings\SettingSingleton::getInstance();
    $show_partners = (int) $settings->getHome('show_partners');
@endphp
@if ($show_partners)
    <!-- partner  -->
    <section class="OurPartner">
        <h3 class=" brownColor">Our Partners</h3>

        <div class="parner">
            <div class="partnercompanies">


                @forelse ($partners as $partner)
                    <div class="ImgDiv">
                        <img class="PartnerImg"src="{{ asset('storage/attachments/partners/' . $partner->image) }}"
                            alt="Client 1">
                    </div>


                @empty

                    <h3>@lang('site.no_partners')</h3>
                @endforelse

            </div>
        </div>


    </section>
    <!-- partner End -->
@endif
