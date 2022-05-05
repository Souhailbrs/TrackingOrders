<section class='expericence-andSkills faqs' id='faq'>
    <div class='container'>
        <div class='row align-items-center'>
            <div class='col-lg-6'>
                <div class='sec-titile-wrapper'>
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
                <!-- end section titile wrapper -->
                <div id='accordion'>
                    @for($i=1;$i<4;$i++)
                        <div class='card custombg'>
                        <div class='card-header' id='headingOne{{$i}}'>
                            <h5 class='mb-0'>
                                <a class='btn btn-link' data-toggle='collapse' data-target='#collapseOne{{$i}}'
                                   aria-expanded='true' aria-controls='collapseOne'>
                                    @foreach($sections as $sec)
                                        @if($sec->section == 'faq' && $sec->field == "headline_title_".App::getLocale().'_'.$i)
                                            {{$sec->value}}
                                        @endif
                                    @endforeach
                                </a>
                            </h5>
                        </div>

                        <div id='collapseOne{{$i}}' class='collapse ' aria-labelledby='headingOne{{$i}}'
                             data-parent='#accordion'>
                            <div class='card-body'>
                                @foreach($sections as $sec)
                                    @if($sec->section == 'faq' && $sec->field == "headline_description_".App::getLocale().'_'.$i)
                                        {{$sec->value}}
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
            <div class='col-lg-4 offset-lg-2 text-lg-right text-sm-center animation' data-animation='bounceInUp'>
                @foreach($sections as $sec)
                    @if($sec->section == 'faq' && $sec->field == "image")
                <img src='{{asset('assets/site/images/main_images/'.$sec->value)}}' alt='' style="height:500px;width:400px">
                    @endif
                    @endforeach
            </div>
        </div>
    </div>
</section>
