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

                    <div class="card-header h5" style="color:#8A3EAF">{{ __('تسجيل دخول') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('auth.login.post') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('البريد الإلكتروني') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('كلمة المرور') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 offset-md-4 text-center">

                                    <button type="submit" class="btn btn-primary" style="background:#8A3EAF">
                                        {{ __('تسجيل دخول') }}
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 text-center">
                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link " style="display:inline;color:#8A3EAF" href="{{ route('forget.password.get') }}" style="color:#8A3EAF">
                                            {{ __('نسيت كلمة المرور ؟ ') }}
                                        </a>
                                    @endif
                                        <br>
                                    <a class="btn btn-link"  style="display:inline;color:#8A3EAF" href="{{ route('site.join_us') }}" style="color:#8A3EAF">
                                        {{ __(' أبدا الان') }}
                                    </a>
                                </div>
                            </div>
                            <br><br>
                            @if($errors->any())
                                <center>
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                       {{$errors->first()}}
                                    </div>
                                </center>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>

        </div>
    </div>
</section>

@endsection
