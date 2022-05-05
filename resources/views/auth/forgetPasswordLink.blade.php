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

                        <form action="{{ route('reset.password.post') }}" method="POST">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group row">
                                <label for="email_address" class="col-md-4 col-form-label text-md-right">البريد الإلكتروني</label>
                                <div class="col-md-6">
                                    <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">كلمة المرور</label>
                                <div class="col-md-6">
                                    <input type="password" id="password" class="form-control" name="password" required autofocus>
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">تأكيد كلمة المرور</label>
                                <div class="col-md-6">
                                    <input type="password" id="password-confirm" class="form-control" name="password_confirmation" required autofocus>
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary" style="background:#8A3EAF">
                                   أعاده تعيين كلمة المرور
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
