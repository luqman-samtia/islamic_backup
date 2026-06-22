@extends('adminlte::page')

@section('title', 'Update Password')

@section('content_header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
<div class="pwd-page">
    <div class="pwd-card">

        {{-- Side panel --}}
        <div class="pwd-aside">
            <div class="pwd-aside__bg"></div>
            <div class="pwd-aside__inner">
                <span class="pwd-aside__icon"><i class="fa fa-lock"></i></span>
                <h2 class="pwd-aside__title">Account Security</h2>
                <p class="pwd-aside__text">
                    Keep your {{ auth()->user()->type === 'admin' ? 'admin' : (auth()->user()->type === 'scholar' ? 'scholar' : 'student') }}
                    account safe by using a strong, unique password.
                </p>
                <ul class="pwd-tips">
                    <li><i class="fa fa-check-circle"></i> Use at least 8 characters</li>
                    <li><i class="fa fa-check-circle"></i> Mix letters, numbers &amp; symbols</li>
                    <li><i class="fa fa-check-circle"></i> Avoid reused passwords</li>
                </ul>
            </div>
        </div>

        {{-- Form side --}}
        <div class="pwd-main">
            <span class="pwd-eyebrow">{{ auth()->user()->type === 'admin' ? 'Admin' : (auth()->user()->type === 'scholar' ? 'Scholar' : 'Student') }} Settings</span>
            <h1 class="pwd-heading">Update Password</h1>
            <p class="pwd-subheading">Enter your current password and choose a new one.</p>

            <form id="updatePasswordForm">
                <div class="pwd-field">
                    <label for="current_password">Current Password</label>
                    <div class="pwd-input">
                        <i class="fa fa-key pwd-input__lead"></i>
                        <input type="password" id="current_password" name="current_password" placeholder="Enter current password">
                        <button type="button" class="pwd-toggle" data-target="current_password"><i class="fa fa-eye"></i></button>
                    </div>
                </div>

                <div class="pwd-field">
                    <label for="new_password">New Password</label>
                    <div class="pwd-input">
                        <i class="fa fa-lock pwd-input__lead"></i>
                        <input type="password" id="new_password" name="new_password" placeholder="Enter new password">
                        <button type="button" class="pwd-toggle" data-target="new_password"><i class="fa fa-eye"></i></button>
                    </div>
                    <div class="pwd-meter"><span id="pwdMeterBar"></span></div>
                    <span class="pwd-meter__label" id="pwdMeterLabel"></span>
                </div>

                <div class="pwd-field">
                    <label for="new_password_confirmation">Confirm New Password</label>
                    <div class="pwd-input">
                        <i class="fa fa-lock pwd-input__lead"></i>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Re-enter new password">
                        <button type="button" class="pwd-toggle" data-target="new_password_confirmation"><i class="fa fa-eye"></i></button>
                    </div>
                </div>

                <button type="submit" class="pwd-submit">
                    <span>Update Password</span>
                    <i class="fa fa-arrow-right"></i>
                </button>
            </form>
        </div>

    </div>
</div>

<div class="rolesModal"></div>
@stop

@section('css')
<style>
    :root {
        --pw-bg:#f6f7fb; --pw-surface:#fff; --pw-ink:#0f1729; --pw-muted:#6b7588;
        --pw-line:#e7e9f1; --pw-indigo:#4f46e5; --pw-indigo-soft:#eef0fe;
    }
    .content-wrapper { background: var(--pw-bg) !important; }

    .pwd-page {
        font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
        display:flex; justify-content:center; padding:14px 2px 30px;
    }
    .pwd-card {
        display:grid; grid-template-columns:0.85fr 1.15fr;
        width:100%; max-width:920px;
        background:var(--pw-surface); border:1px solid var(--pw-line);
        border-radius:22px; overflow:hidden;
        box-shadow:0 24px 50px -28px rgba(16,23,41,.32);
    }

    /* ----- Aside ----- */
    .pwd-aside { position:relative; color:#fff; min-height:100%; }
    .pwd-aside__bg {
        position:absolute; inset:0;
        background:linear-gradient(150deg,#1a1f3a 0%,#2d2461 55%,#4f46e5 100%);
    }
    .pwd-aside__bg::after {
        content:''; position:absolute; inset:0;
        background-image:
            radial-gradient(circle at 85% 12%, rgba(199,159,26,.30), transparent 45%),
            radial-gradient(circle at 10% 100%, rgba(225,29,107,.22), transparent 50%);
    }
    .pwd-aside__inner { position:relative; padding:40px 32px; }
    .pwd-aside__icon {
        display:inline-flex; align-items:center; justify-content:center;
        width:54px; height:54px; border-radius:16px; font-size:22px;
        background:rgba(255,255,255,.14); border:1px solid rgba(255,255,255,.22);
        margin-bottom:22px;
    }
    .pwd-aside__title { font-size:22px; font-weight:700; margin:0 0 10px; letter-spacing:-.01em; }
    .pwd-aside__text { font-size:14px; color:rgba(255,255,255,.74); line-height:1.55; margin:0 0 24px; }
    .pwd-tips { list-style:none; padding:0; margin:0; }
    .pwd-tips li {
        font-size:13.5px; color:rgba(255,255,255,.85);
        display:flex; align-items:center; gap:10px; margin-bottom:12px;
    }
    .pwd-tips li i { color:#c79f1a; font-size:14px; }

    /* ----- Main / form ----- */
    .pwd-main { padding:40px 38px; }
    .pwd-eyebrow {
        display:inline-block; font-size:11.5px; letter-spacing:.13em; text-transform:uppercase;
        font-weight:600; color:var(--pw-indigo); margin-bottom:10px;
    }
    .pwd-heading { font-size:27px; font-weight:700; color:var(--pw-ink); margin:0 0 6px; letter-spacing:-.02em; }
    .pwd-subheading { font-size:14px; color:var(--pw-muted); margin:0 0 28px; }

    .pwd-field { margin-bottom:20px; }
    .pwd-field > label {
        display:block; font-size:13px; font-weight:600; color:var(--pw-ink); margin-bottom:8px;
    }
    .pwd-input { position:relative; display:flex; align-items:center; }
    .pwd-input__lead {
        position:absolute; left:15px; color:var(--pw-muted); font-size:14px; pointer-events:none;
    }
    .pwd-input input {
        width:100%; height:48px; border:1px solid var(--pw-line); border-radius:12px;
        background:#fbfbfe; padding:0 44px 0 42px; font-size:14px; color:var(--pw-ink);
        transition:border-color .2s, box-shadow .2s, background .2s;
    }
    .pwd-input input::placeholder { color:#aab0bf; }
    .pwd-input input:focus {
        outline:none; border-color:var(--pw-indigo); background:#fff;
        box-shadow:0 0 0 4px var(--pw-indigo-soft);
    }
    .pwd-toggle {
        position:absolute; right:8px; width:32px; height:32px; border:none; background:transparent;
        color:var(--pw-muted); cursor:pointer; border-radius:8px; transition:color .2s, background .2s;
    }
    .pwd-toggle:hover { color:var(--pw-indigo); background:var(--pw-indigo-soft); }

    /* strength meter */
    .pwd-meter { height:5px; border-radius:999px; background:var(--pw-line); margin-top:10px; overflow:hidden; }
    .pwd-meter span {
        display:block; height:100%; width:0; border-radius:999px;
        transition:width .3s ease, background .3s ease;
    }
    .pwd-meter__label { font-size:12px; font-weight:600; display:inline-block; margin-top:6px; }

    /* error message */
    .error-message { display:block; color:#e11d48; font-size:12.5px; margin-top:6px; }

    /* submit */
    .pwd-submit {
        display:inline-flex; align-items:center; gap:10px;
        margin-top:6px; padding:13px 26px; border:none; border-radius:12px;
        background:linear-gradient(135deg,#4f46e5,#6d28d9); color:#fff;
        font-size:14.5px; font-weight:600; cursor:pointer;
        transition:transform .2s, box-shadow .2s, opacity .2s;
        box-shadow:0 12px 24px -12px rgba(79,70,229,.7);
    }
    .pwd-submit:hover { transform:translateY(-2px); box-shadow:0 18px 30px -14px rgba(79,70,229,.8); }
    .pwd-submit:active { transform:translateY(0); }
    .pwd-submit i { transition:transform .2s; }
    .pwd-submit:hover i { transform:translateX(3px); }

    /* ----- responsive ----- */
    @media (max-width:768px) {
        .pwd-card { grid-template-columns:1fr; }
        .pwd-aside { display:none; }
        .pwd-main { padding:32px 24px; }
    }
    @media (prefers-reduced-motion:reduce) {
        .pwd-submit, .pwd-submit i, .pwd-input input, .pwd-meter span { transition:none; }
        .pwd-submit:hover { transform:none; }
    }
</style>
@stop

@push('js')
<script>
$(document).ready(function () {

    // ---- Show / hide password ----
    $('.pwd-toggle').on('click', function () {
        var id = $(this).data('target');
        var input = document.getElementById(id);
        var icon = $(this).find('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // ---- Password strength meter ----
    $('#new_password').on('input', function () {
        var val = $(this).val();
        var score = 0;
        if (val.length >= 8) score++;
        if (/[A-Z]/.test(val)) score++;
        if (/[0-9]/.test(val)) score++;
        if (/[^A-Za-z0-9]/.test(val)) score++;

        var bar = $('#pwdMeterBar');
        var label = $('#pwdMeterLabel');
        var widths = ['0%', '30%', '55%', '80%', '100%'];
        var colors = ['', '#e11d48', '#f59e0b', '#3b82f6', '#0f9d6b'];
        var texts  = ['', 'Weak', 'Fair', 'Good', 'Strong'];

        if (val.length === 0) score = 0;
        bar.css({ width: widths[score], background: colors[score] });
        label.text(texts[score]).css('color', colors[score] || '');
    });

    // ---- Submit (original logic kept intact) ----
    $('#updatePasswordForm').on('submit', function (e) {
        e.preventDefault();

        let currentPassword = $('#current_password').val();
        let newPassword = $('#new_password').val();
        let confirmPassword = $('#new_password_confirmation').val();

        $('.error-message').remove();

        $.ajax({
            type: 'POST',
            url: '{{ route("information.student.update-password") }}',
            data: {
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    });
                    $('#updatePasswordForm')[0].reset();
                    $('#pwdMeterBar').css('width', '0');
                    $('#pwdMeterLabel').text('');
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        $('#' + key).closest('.pwd-field')
                            .append('<span class="error-message">' + value[0] + '</span>');
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: (xhr.responseJSON && xhr.responseJSON.error) || 'An error occurred',
                    });
                }
            }
        });
    });
});
</script>
@endpush