<header  id='home' style="display:block">
    <nav class='navbar navbar-expand-lg  main-menu  fixed-top navbar-toggle ' id="mynav">
        <div class='container-fluid custom-container '>
            @foreach($sections as $sec)
                @if($sec->section == 'home_page' && $sec->field == "logo_black")
            <a href='{{route('site.home')}}' class='navbar-brand navbar-brand-img' ><img class="logo" src="{{asset('assets/site/images/main_images/')}}" alt='' style="width:100px;height: 70px"> </a>
                @endif
            @endforeach

            <div class='collapse navbar-collapse' id='siteNav'>
                <ul class='navbar-nav ml-auto'>
                    <li class='nav-item'><a href='{{route('auth.login')}}' class='nav-link smooth-scroll'>Login</a></li>
                    <li class='nav-item'><a href='#feature' class='nav-link smooth-scroll'>FEATURE</a></li>
                    <li class='nav-item'><a href='#abouts' class='nav-link smooth-scroll'>about us</a></li>
                    <li class='nav-item'><a href='#screen' class='nav-link smooth-scroll'>screen</a></li>
                    <li class='nav-item'><a href='#faq' class='nav-link smooth-scroll'>FAQS</a></li>
                    <li class='nav-item'><a href='#team' class='nav-link smooth-scroll'>team</a></li>
                    <li class='nav-item'><a href='#price' class='nav-link smooth-scroll'>PRICING</a></li>
                    <li class='nav-item'><a href='#contacts' class='nav-link smooth-scroll'>CONTACTS</a></li>
                    <li><a href='{{route('site.join_us')}}' class='btn-mr btn btn-success' style="border-radius: 20px"> Join Us</a></li>
                </ul>
            </div>

        </div>
    </nav>
</header>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>


    $(function () {
        @foreach($sections as $sec)
        @if($sec->section == 'home_page' && $sec->field == "logo_black")
             $('.navbar-brand-img img').attr('src','{{asset('assets/site/images/main_images/'. $sec->value)}}');
        @endif
        @endforeach
        $('.main-menu ul > li.nav-item > a.nav-link').css({'color':'green'});
        $('.main-menu').css({'background':'white'});

        $(window).scroll(function () {
            if ($(this).scrollTop() > 50) {
                @foreach($sections as $sec)
                @if($sec->section == 'home_page' && $sec->field == "logo_white")
                $('.navbar-brand-img img').attr('src','{{asset('assets/site/images/main_images/'. $sec->value)}}');
                @endif
                @endforeach
                $('.main-menu').css({'background':'#28a745'});
                $('.main-menu ul > li.nav-item > a.nav-link').css({'color':'white'});
            }else if($(this).scrollTop() < 50) {
                @foreach($sections as $sec)
                @if($sec->section == 'home_page' && $sec->field == "logo_black")
                $('.navbar-brand-img img').attr('src','{{asset('assets/site/images/main_images/'. $sec->value)}}');
                @endif
                @endforeach
                $('.main-menu').css({'background':'white'});
                $('.main-menu ul > li.nav-item > a.nav-link').css({'color':'green'});

            }
        })
    });

</script>
