<section class='expericence-andSkills' id='abouts'>
    <div class='container'>
        <div class='row align-items-center'>
            <div class='col-lg-6 col-xl-6'>
                <div class='sec-titile-wrapper'>
                    <h2 class='section-title'>
                        @foreach($sections as $sec)
                            @if($sec->section == 'experience' && $sec->field == "title_".App::getLocale())
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </h2>
                    <p>
                        @foreach($sections as $sec)
                            @if($sec->section == 'experience' && $sec->field == "details_".App::getLocale())
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </p>
                </div>
                <!-- end section titile wrapper -->
                @for($i=1;$i<4;$i++)
                <div class='miniSkilss'>
                    <h4>
                        @foreach($sections as $sec)
                            @if($sec->section == 'experience' && $sec->field == "headline_title_".App::getLocale().'_'.$i)
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </h4>
                    <p>
                        @foreach($sections as $sec)
                            @if($sec->section == 'experience' && $sec->field == "headline_description_".App::getLocale().'_'.$i)
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </p>
                </div>
                @endfor
            </div>
            <div class='col-lg-6 col-xl-4 align-self-lg-center  offset-xl-1 align-self-xl-end animation'
                 data-animation='bounceInUp'>
                <div class='skl-mbl-img'>
                    @foreach($sections as $sec)
                        @if($sec->section == 'experience' && $sec->field == "image")
                            <img src='{{asset('assets/site/images/main_images/'.$sec->value)}}' alt='' >
                        @endif
                    @endforeach
                </div>
                <!-- end skl mobile image -->
            </div>
        </div>
    </div>
</section>
