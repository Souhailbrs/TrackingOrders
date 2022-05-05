<section class='get_intocuh' id='contacts'>
    <div id='googleMap'></div>
    <!-- google map -->
    <div class='container'>
        <div class='row'>
            <div class='col-12 get-in-box'>
                <div class='row'>
                    <h3 class='col-lg-9 offset-lg-1 get-title'>Get In Touch</h3>
                    <div class='col-lg-3 offset-lg-1 col-md-4'>
                        <div class='single-get-intocuh'>

                            <h5><i class='icofont icofont-social-google-map'></i>Address</h5>
                            <address>
                                @foreach($sections as $sec)
                                    @if($sec->section == 'contact' && $sec->field == "address_".App::getLocale())
                                        {{$sec->value}}
                                    @endif
                                @endforeach
                            </address>
                        </div>
                        <!-- end single get in touch -->
                    </div>
                    <!-- end single get in touch -->
                    <div class='col-lg-4 text-md-center col-md-4'>
                        <div class='single-get-intocuh border-LR'>

                            <h5><i class='icofont icofont-ui-call'></i>Phone</h5>
                            <address>
                                @foreach($sections as $sec)
                                    @if($sec->section == 'contact' && $sec->field == "phone1")
                                        {{$sec->value}}
                                    @endif
                                @endforeach
                               <br>
                                    @foreach($sections as $sec)
                                        @if($sec->section == 'contact' && $sec->field == "phone2")
                                            {{$sec->value}}
                                        @endif
                                    @endforeach
                            </address>
                        </div>
                        <!-- end single get in touch -->
                    </div>
                    <!-- end single get in touch -->
                    <div class='col-lg-3 offset-lg-1 col-md-4'>
                        <div class='single-get-intocuh'>
                            <h5><i class='icofont icofont-email'></i>Email</h5>
                            <address>
                                    @foreach($sections as $sec)
                                        @if($sec->section == 'contact' && $sec->field == "email1")
                                            {{$sec->value}}
                                        @endif
                                    @endforeach
                                        <br>
                                        @foreach($sections as $sec)
                                            @if($sec->section == 'contact' && $sec->field == "email2")
                                                {{$sec->value}}
                                            @endif
                                        @endforeach

                            </address>
                        </div>
                        <!-- end single get in touch -->
                    </div>
                    <!-- end single get in touch -->
                </div>
            </div>
            <!-- end get in box -->
            <div class='col-12 get-in-form'>
                <form>
                    <div class='form-row'>
                        <div class='col-md-6'>
                            <input type='text' class='form-control' placeholder='Name'>
                        </div>
                        <div class='col-md-6'>
                            <input type='tel' class='form-control' placeholder='mobile'>
                        </div>
                        <div class='col-md-6'>
                            <input type='email' class='form-control' placeholder='email'>
                        </div>
                        <div class='col-md-6'>
                            <input type='text' class='form-control' placeholder='subject'>
                        </div>
                        <div class='col-md-12'>
                            <textarea class='form-control' placeholder='write your message'></textarea>
                        </div>
                    </div>
                    <div class='text-right'>
                        <button type='submit' class='btn-mr th-primary pill'>SEND</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
