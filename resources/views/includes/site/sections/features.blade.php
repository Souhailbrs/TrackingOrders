<section class='feature-area' id='feature'>
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

            <div class='col-lg-3 col-sm-6 text-center animation' data-animation='fadeInUp' data-animation-delay='0.1s'>
                <div class='single-feature'>
                    <img src='{{asset('assets/site/images/all-img/s1.png')}}' alt=''>
                    <h3>
                        @foreach($sections as $sec)
                        @if($sec->section == 'features' && $sec->field == "feature_title_".App::getLocale()."_1")
                            {{$sec->value}}
                        @endif
                        @endforeach
                    </h3>
                    <p>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_description_".App::getLocale()."_1")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>

            <div class='col-lg-3 col-sm-6 text-center animation' data-animation='fadeInUp' data-animation-delay='0.16s'>
                <div class='single-feature'>
                    <img src='{{asset('assets/site/images/all-img/s3.png')}}' alt=''>
                    <h3>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_title_".App::getLocale()."_2")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </h3>
                    <p>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_description_".App::getLocale()."_2")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>


            <div class='col-lg-3 col-sm-6 text-center animation' data-animation='fadeInUp' data-animation-delay='0.19s'>
                <div class='single-feature'>
                    <img src='{{asset('assets/site/images/all-img/s4.png')}}' alt=''>
                    <h3>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_title_".App::getLocale()."_3")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </h3>
                    <p>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_description_".App::getLocale()."_3")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
            <div class='col-lg-3 col-sm-6 text-center animation' data-animation='fadeInUp' data-animation-delay='0.13s'>
                <div class='single-feature'>
                    <img src='{{asset('assets/site/images/all-img/s2.png')}}' alt=''>
                    <h3>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_title_".App::getLocale()."_4")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </h3>
                    <p>
                        @foreach($sections as $sec)
                            @if($sec->section == 'features' && $sec->field == "feature_description_".App::getLocale()."_4")
                                {{$sec->value}}
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>

        </div>
    </div>
</section>
