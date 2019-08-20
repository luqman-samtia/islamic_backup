<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" sizes="32x32" type="image/png">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.circliful.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/colors/color.css') }}" title="color" />
    <link rel="alternate stylesheet" href="{{ asset('assets/css/colors/color2.css') }}" title="color2" />
    <link rel="alternate stylesheet" href="{{ asset('assets/css/colors/color3.css') }}" title="color3" />
    <link rel="alternate stylesheet" href="{{ asset('assets/css/colors/color4.css') }}" title="color4" />

    @yield('custom_css')

</head>
<body>
    @yield('content')
{{--<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>--}}
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/downCount.js') }}"></script>
    <script src="{{ asset('assets/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/perfectscrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.circliful.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-scripts.js') }}"></script>

    @yield('custom_js')

</body>
</html>