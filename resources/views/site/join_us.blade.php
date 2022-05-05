@extends('layouts.trackingLanding')
@section('content')
<section class="theme-bg overflow-hidden home-section" id="home">
    <div id="particles-js">
    </div>
    <div class='container'>
        <br><br><br><br>
        <div class='row'>
            <div class="col-sm-12 text-center h1 btn  p-3" style="color:white;font-weight:bolder;font-family: Cairo!important;font-size: 33px">
                أبدا الان
            </div>
        </div>
        <br>
        @if(Session::has('message'))
            <div class='row'>
                <div class="col-sm-12 text-center h1 btn btn-light ">
                    {{ Session::get('message') }}
                </div>
            </div>
        @else
            <div class='row'>
                <div class="col-sm-12 text-center h1 btn btn-light ">
                    أرسل طلب انضمام وسوف نتواصل معك
                </div>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <br><br>
        <div class='row'>
            <!-- end get in box -->
            <div class='col-12 get-in-form'>
                <form action="{{route('send.join.request')}}" method="post">
                    @csrf
                    <div class='form-row' >
                        <div class='col-md-6 mt-1'>
                            <input type='text' class=' form-control' placeholder='قم بإدخال اسمك' required name='name' style="font-weight:lighter">
                        </div>
                        <div class='col-md-6 mt-1'>
                            <input type='tel' class=' form-control' placeholder='قم بإدخال رقم الهاتف' required name="phone" style="font-weight:lighter">
                        </div>
                        <div class='col-md-6 mt-1'>
                            <input type='email' class=' form-control' placeholder='قم بإدخال بريدك الإلكتروني' required name="email" style="font-weight:lighter">
                        </div>
                        <div class='col-md-6 mt-1'>
                            <input type='password' class=' form-control' placeholder='قم بإدخال كلمة المرور' required name="password" style="font-weight:lighter">
                        </div>

                    </div>

                    <div class='text-center mt-3'>
                        <button type='submit' class='btn btn-light'>إرسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

