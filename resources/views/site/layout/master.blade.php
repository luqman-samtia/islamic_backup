<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" sizes="32x32" type="image/png">
    <title>@yield('title', config('app.name'))</title>
    <link rel="stylesheet" href="{{ asset('assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.circliful.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    {{-- for toast --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
        .dropdown-menu {
    min-width: 200px; /* Set width for dropdown */
}
/* floating */
.floating-buttons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999999;
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
/* login_register Modal css */
.modal {
display: none;
position: fixed;
z-index: 999;
left: 0;
top: 0;
width: 100%;
height: 100%;
overflow: auto;
background-color: rgb(0,0,0);
background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
 /* Pageloader css */
.pageloader-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    width: 100vw;
    background-color: #ffffff; 
    position: fixed;
    top: 0;
    left: 0;
    z-index: 99999;
}

.custom-quran-loader {
    width: 90px;
    height: 90px;
    animation: float-quran 2.5s ease-in-out infinite;
}

.book-path, .rehal-path {
    fill: transparent;
    stroke: #cda253; 
    stroke-width: 3.5;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.book-path {
    stroke-dasharray: 200;
    stroke-dashoffset: 200;
    animation: draw-quran 2s ease-in-out infinite alternate;
}

.rehal-path {
    stroke-dasharray: 50;
    stroke-dashoffset: 50;
    animation: draw-rehal 2s ease-in-out infinite alternate;
    animation-delay: 0.2s; 
}

@keyframes draw-quran {
    0% { stroke-dashoffset: 200; fill: transparent; }
    100% { stroke-dashoffset: 0; fill: rgba(205, 162, 83, 0.15);  }
}

@keyframes draw-rehal {
    0% { stroke-dashoffset: 50; }
    100% { stroke-dashoffset: 0; }
}

@keyframes float-quran {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
}
/* End page loader css  */
    .sticky-admission-bar {
        position: fixed;
        bottom: -150%; /* Start hidden below screen */
        left: 0;
        width: 100%;
        background: #1a1a1a; /* Dark premium background */
        border-top: 3px solid #cfa54f; /* Golden border */
        box-shadow: 0 -5px 25px rgba(0,0,0,0.6);
        z-index: 999999;
        padding: 15px 0;
        /* Bouncy slide-up animation */
        transition: bottom 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    }
    
    /* Class to trigger the slide up */
    .sticky-admission-bar.show {
        bottom: 0;
    }

    /* Glowing Button Animation */
    .glow-btn-premium {
        background-color: #cfa54f !important;
        color: #fff !important;
        border: none;
        animation: glowing-gold 2s infinite;
        transition: all 0.3s ease;
        padding: 12px 35px !important;
        font-size: 16px !important;
        display: inline-block;
    }
    .glow-btn-premium:hover {
        background-color: #b38b3f !important;
        transform: translateY(-2px);
    }
    @keyframes glowing-gold {
        0% { box-shadow: 0 0 5px rgba(207, 165, 79, 0.4); }
        50% { box-shadow: 0 0 15px rgba(207, 165, 79, 0.8), 0 0 25px rgba(207, 165, 79, 0.5); }
        100% { box-shadow: 0 0 5px rgba(207, 165, 79, 0.4); }
    }

    /* Blinking Badge */
    .blink-badge {
        background: rgba(207, 165, 79, 0.15); 
        color: #cfa54f; 
        padding: 4px 12px; 
        border-radius: 30px; 
        font-size: 12px; 
        font-weight: bold; 
        border: 1px solid #cfa54f; 
        display: inline-block; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        animation: blinking-text 1.5s infinite;
        margin-right: 15px;
        vertical-align: middle;
    }
    @keyframes blinking-text {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* Close Button */
    .close-sticky-bar {
        background: transparent;
        border: none;
        color: #aaaaaa;
        font-size: 26px;
        margin-left: 20px;
        cursor: pointer;
        transition: 0.3s;
        vertical-align: middle;
    }
    .close-sticky-bar:hover {
        color: #cfa54f;
    }

    /* Mobile Responsive Adjustments */
   @media (max-width: 768px) {
    .sticky-txt-wrap { text-align: left; margin-bottom: 15px; } 
    .sticky-btn-wrap { text-align: center; }
    .blink-badge { margin-bottom: 8px; }
    
    .mobile-hd-txt { font-size: 18px !important; }
    .mobile-p-txt { font-size: 13px !important; line-height: 1.4 !important; }
    
    .floating-buttons.lifted {
        bottom: 210px !important; 
    }
}
    </style>

</head>
<body>
    @yield('content')
{{--<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>--}}
    <script src="{{ asset('assets/js/jquery.min.js') }}?v=3"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/downCount.js') }}"></script>
    <script src="{{ asset('assets/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/perfectscrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.circliful.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/custom-scripts.js') }}?v=2"></script> --}}
    <script src="{{ asset('assets/js/custom-scripts.js') }}?v={{ filemtime(public_path('assets/js/custom-scripts.js')) }}"></script>


    @yield('custom_js')
    <!-- Floating buttons -->
    <div class="floating-buttons">
        @php($info = \App\Information::query()->first())
        <!-- WhatsApp Button -->
        @if(@$info['whatsapp2']['label'] && @$info['whatsapp2']['value'])      
        <a href="https://wa.me/{{$info['whatsapp2']['value']}}" target="_blank" class="whatsapp-button">
            <img src="{{ asset('assets/images/whatsapp.png') }}" alt="WhatsApp">
        </a>
        @endif
        <!-- Skype Button -->
        @if(@$info['skype1']['label'] && @$info['skype1']['value'])        
        <a href="https://teams.microsoft.com/l/call/0/0?users={{$info['skype1']['value']}}" target="_blank" class="skype-button">
            <img src="{{ asset('assets/images/pngwing2.png') }}" alt="Teams">
        </a>
        @endif
    </div>
</body>
</html>
