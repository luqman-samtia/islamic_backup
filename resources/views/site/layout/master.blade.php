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
    <script>
        if(performance.navigation.type == 2){
            location.reload(true);
        }
    </script>

    <style>
        /* floating */
        .floating-buttons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 999;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.floating-buttons a {
    display: inline-block;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.floating-buttons a:hover {
    transform: scale(1.1);
}

.floating-buttons img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
}
/* end floating */
        .thm-btn, .secndry-btn{
            box-shadow: 0 5px 10px rgba(0,0,0,0.15) !important;
        }
        header.sticky-active{
            box-shadow: none !important;
        }
        @media only screen and (min-width: 996px) {

            .sticky{
                position: fixed;
                top: 80px;
                background-color: white;
                z-index: 99;
                box-shadow: 0 3px 5px rgba(0,0,0,.08);
                width: 100%;
                left: 15px;
            }
            .contact-form-row.sticky .contact-form{
                margin-bottom: 10px !important;
            }
        }
        
   
    </style>

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
    <!-- Floating buttons -->
    <div class="floating-buttons">
        <!-- WhatsApp Button -->
        <a href="https://wa.me/923001425825" target="_blank" class="whatsapp-button">
            <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp">
        </a>
    
        <!-- Skype Button -->
        <a href="skype:live:live:428db5f55825624c?call" target="_blank" class="skype-button">
            <img src="{{ asset('assets/images/skype.png') }}" alt="Skype">
        </a>
    </div>
</body>
</html>
