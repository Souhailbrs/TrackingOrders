@extends('layouts.trackingLanding')
@section('content')
    <section class="theme-bg overflow-hidden home-section" id="home">
        <div id="particles-js">
        </div>
        <br><br><br><br><br><br>
        <div class='container '>
            <div class="row">
                <div class="col-2"></div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header h5" style="color:#8A3EAF">{{ __('أعادة تعيين كلمة المرور') }}</div>
                    <div class="card-body">

                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif

                        <form action="{{ route('forget.password.post') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">البريد الإلكتروني</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="background:#8A3EAF">
                                   أرسال رابط تعيين كلمة المرور
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
                <div class="col-2"></div>
            </div>
        </div>
    </section>
@endsection
