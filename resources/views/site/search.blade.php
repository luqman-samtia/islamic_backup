@extends('site.layout.master')

@section('title', 'Search')

@section('custom_css')
    <style>
        .contact-form > form{
            max-width: none;
        }
        .contact-form > form input, .contact-form > form select, .contact-form > form textarea{
            border: 1px solid #ededed;
        }
     
        /* Default styles for the contact form row */
.contact-form-row {
    transition: all 0.3s ease; /* Smooth transition */
}

/* Sticky styles */
.sticky {
    position: fixed; /* Fixes the form to the top */
    top: 0; /* Aligns it to the top */
    left: 0; /* Aligns it to the left */
    width: 100%; /* Ensures it takes the full width */
    z-index: 1000; /* Keeps it above other content */
    background-color: white; /* Background color for visibility */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
}
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stop

@section('content')
    <main>
        @include('site.inc.loader')
        @include('site.inc.header')
       
        @include('site.inc.header_responsive')

        <section>
            <div class="gap remove-bottom black-layer2 opc85">
                <div class="fixed-bg" style="background-image: url('{{ asset('assets/images/parallax12.jpg') }}');"></div>
                <div class="container">
                    <div class="page-title-wrap">
                        <h2>Search</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>Search</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap" style="padding-top: 20px;">
                <div class="container">
                    <div class="prtfl-wrap">
                        <div class="serv-wrap remove-ext3">
                            {{-- <header class="style1"> --}}
                                <div class="row contact-form-row style1" id="stickyFormContainer" >
                                    <div class="col-md-12">
                                        <div class="contact-form " id="stickyForm">
                                            <form id="searchForm" action="{{ route('search') }}">
                                                <div class="row mrg20 justify-content-center align-items-center text-center">
                                                    <div class="col-md-2 col-sm-6 col-lg-2">
                                                        <select name="surat" onchange="this.form.submit()">
                                                            <option value="">-- Select Option --</option>
                                                            @foreach($quran as $surat)
                                                                <option {{ $request->surat == $surat->slug ? "selected" : "" }} value="{{ $surat->slug }}">{{ $surat->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-md-2 col-sm-6 col-lg-2">
                                                        <input type="number" name="ayat_from" placeholder="Ayat From" value="{{ $request->ayat_from }}">
                                                    </div>
                                                    <div class="col-md-2 col-sm-6 col-lg-2">
                                                        <input type="number" name="ayat_to" placeholder="Ayat To" value="{{ $request->ayat_to }}">
                                                    </div> --}}
                                                    <div class="col-md-2 col-sm-6 col-lg-2">
                                                        <input type="number" name="page" placeholder="Page" value="">
                                                    </div>
                                                    <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="para_no" id="para_no" class="form-control" min="1" max="30" placeholder="Enter Para Number" >
                                                    </div>

                                                    <div class="col-md-2 col-sm-12 col-lg-2">
                                                        <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                                                    </div>
                                                    {{-- <div class="col-md-2 col-sm-12 col-lg-2">
                                                        <button type="button" class="thm-btn brd-rd40 mt-3"  onclick="openPageModal()"   >Search</button>
    
                                                    </div> --}}
                                                </div>
                                            </form>
                                        </div>
                                         
                                    </div>

                                       <!-- Your navigation content -->
                                       <div class="col-md-12 col-lg-12 w-100 text-center">
                                        <div class="navbar-container">
                                            <div id="navbar" class="navbar"> <!-- Ensure this ID is present -->
                                                <div class="col-md-12 w-100 text-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <!-- Previous Button -->
                                                        <div>
                                                            @if(@$previous)
                                                                <a href="{{ route('search', $previous) }}" class="thm-btn brd-rd40 mt-2" type="submit">Previous</a>
                                                            @endif
                                                        </div>
                                                        <!-- Center Button -->
                                                        <div>
                                                            @if($parent_slug)
                                                                <a href="{{ route('quranSurat', $parent_slug) }}" class="thm-btn brd-rd40 mt-4">{{ $parent_surat }}</a>
                                                            @endif
                                                        </div>
                                                        <!-- Next Button -->
                                                        <div>
                                                            @if(@$next)
                                                                <a href="{{ route('search', $next) }}" class="thm-btn brd-rd40 mt-2" type="submit">Next</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{-- </header> --}}
                            

                             <!-- Modal -->
                              <!-- Modal -->
                        

                            <!-- JavaScript -->

                                {{-- End Modal --}}
                            <div class="row">
                                @if(isset($error))
                                <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3 text-center">
                                    {{ $error }}
                                </div>
                                    @endif
                                    
                                @foreach($search as $child)
                                    <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3 text-center">
                                        <labe>
                                            {{-- {{ $child->title }} --}}
                                            <br>
                                            Page - {{ $child->number }}
                                            </small>
                                        </labe>
{{--                                        <a href="{{ asset('/storage/'.$child->image) }}" data-fancybox="gallery" title="">--}}
                                            <br>
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}" width="100%">
{{--                                        </a>--}}
                                    </div>
                                @endforeach
                                    <div class="col-md-12 w-100 text-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Previous Button -->
                                            <div>
                                                @if(@$previous)
                                                    <a href="{{ route('search', $previous) }}" 
                                                       class="thm-btn brd-rd40 mt-2" 
                                                       type="submit">Previous</a>
                                                @endif
                                            </div>
                                            
                                            <!-- Center Button -->
                                            <div>
                                                @if($parent_slug )
                                                <a href="{{ route('quranSurat', $parent_slug) }}" 
                                                   class="thm-btn brd-rd40 mt-2">{{ $parent_surat }}</a>
                                                   @endif
                                            </div>
                                    
                                            <!-- Next Button -->
                                            <div>
                                                @if(@$next)
                                                    <a href="{{ route('search', $next ) }}" 
                                                       class="thm-btn brd-rd40 mt-2" 
                                                       type="submit">Next</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('site.inc.footer')
    </main>
@stop

@section('custom_js')
    <script >
  $(document).ready(function() {
        var contactFormRow = $('#stickyFormContainer').offset().top;
    
        $(window).on('scroll', function() {
            var scroll = $(window).scrollTop();

            if (scroll >= contactFormRow) {
                $('#stickyFormContainer').addClass('sticky-active');
            } else {
                $('#stickyFormContainer').removeClass('sticky-active');
            }
        });
    });


      
    
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = message;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('visible');
            }, 100);
            setTimeout(() => {
                toast.classList.remove('visible');
                document.body.removeChild(toast);
            }, 5000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('error'))
                showToast('{{ session('error') }}');
            @endif
        });
// Get the navbar
var navbar = document.getElementById("navbar");

// Get the offset position of the navbar
var sticky = navbar.offsetTop;

// Add the scroll event listener
window.onscroll = function() {
    if (window.pageYOffset > sticky) {
        navbar.classList.add("sticky");
    } else {
        navbar.classList.remove("sticky");
    }
};

    </script>
@stop
