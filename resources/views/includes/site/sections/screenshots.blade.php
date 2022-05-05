<section class='amazing-screen' id='screen'>
    <div class='container'>
        <div class='row'>
            <div class='col-lg-8 offset-lg-2 sec-titile-wrapper text-center'>
                @foreach($sections as $sec)
                    @if($sec->section == 'features' && $sec->field == "title_".App::getLocale())
                        <h2 class='section-title'>{{$sec->value}}</h2>
                    @endif
                    <p>
                        @if($sec->section == 'features' && $sec->field == "details_".App::getLocale())
                            {{$sec->value}}
                        @endif
                    </p>
                @endforeach

            </div>
            <!-- end section-titile -->
            <div class='col-12'>
                <div class='swiper-container s1'>
                    <div class='swiper-wrapper'>
                        <div class='swiper-slide'><img src='{{asset('assets/site/images/all-img/Screen-one.png')}}' alt=''></div>
                        <div class='swiper-slide'><img src='{{asset('assets/site/images/all-img/App-01.png')}}' alt=''></div>
                        <div class='swiper-slide'><img src='{{asset('assets/site/images/all-img/App-02.png')}}' alt=''></div>
                        <div class='swiper-slide'><img src='{{asset('assets/site/images/all-img/App-3.png')}}' alt=''></div>
                        <div class='swiper-slide'><img src='{{asset('assets/site/images/all-img/App-4.png')}}' alt=''></div>
                        <div class='swiper-slide'><img src='{{asset('assets/site/images/all-img/App-5.png')}}' alt=''></div>


                    </div>
                    <!-- Add Pagination -->
                    <div class='swiper-pagination one'></div>
                </div>
            </div>
        </div>
    </div>

</section>
