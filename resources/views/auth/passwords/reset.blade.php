{{-- @extends('adminlte::passwords.reset') --}}

@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@section('body_class', 'hold-transition login-page')

@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset') )
@php( $url = $password_reset_url )

@section('body')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>Taleem ul Quran</b> Institute</a>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Reset your password</p>

            <form action="{{ url($url) }}" method="post">
                @csrf

                <input type="hidden" name="token" value="{{ request()->token ?? $token ?? '' }}">

                <div class="input-group mb-3">
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ request()->email ?? old('email') }}"
                           placeholder="Email" required autofocus>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="New Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation"
                           class="form-control"
                           placeholder="Confirm Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            Change Password
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1 text-center">
                <a href="{{ url('/') }}">Back to login</a>
            </p>
        </div>
    </div>
</div>
@stop