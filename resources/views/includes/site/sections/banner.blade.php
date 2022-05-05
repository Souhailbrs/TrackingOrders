@foreach($sections as $sec)
    @if($sec->section == 'home_page' && $sec->field == "background")
        <section style="  background-repeat: no-repeat;
            background-size: cover; background-position: center center;background-image:url('{{asset('assets/site/images/main_images/'. $sec->value)}}');height:100%;width:100%;">
            @endif
            @endforeach
            <div class='container'>
                <div class='row'>
                    <div class='col-lg-8 offset-lg-2 sec-titile-wrapper text-center'>
                        <br><br><br><br><br><br><br>
                        @foreach($sections as $sec)
                        @if($sec->section == 'home_page' && $sec->field == "title_".App::getLocale())
                        <h2 class='section-title'>
                                {{$sec->value}}
                        </h2>
                        @endif
                        @endforeach
                        @foreach($sections as $sec)
                        @if($sec->section == 'home_page' && $sec->field == "details_".App::getLocale())
                        <p class="h6">
                                {{$sec->value}}
                        </p>
                        @endif
                        @endforeach
                        <a class="btn btn-success" href="{{route('site.join_us')}}" style="border-radius: 20px">
                            Join Us
                        </a>
                    </div>

                </div>
            </div>
        </section>

