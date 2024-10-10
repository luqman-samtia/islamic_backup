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
        .toast {
    position: fixed;
    top: 20px; /* Change this from bottom to top */
    right: 20px; /* Keep this for right positioning */
    background-color: #eb0909;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    z-index: 9999; /* Ensure it appears above other elements */
}

.toast.visible {
    opacity: 1;
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
                            <div class="row contact-form-row">
                                <div class="col-md-12">
                                    <div class="contact-form mb-5">
                                        <form action="{{ route('search') }}">
                                            <div class="row mrg20">
                                                <div class="col-md-4 col-sm-6 col-lg-4">
                                                    <select name="surat" >
                                                        <option value="">-- Select Option --</option>
                                                        @foreach($quran as $surat)
                                                            <option {{ $request->surat == $surat->slug ? "selected" : "" }} value="{{ $surat->slug }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="ayat_from" placeholder="Ayat From" value="{{ $request->ayat_from }}">
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="ayat_to" placeholder="Ayat To" value="{{ $request->ayat_to }}">
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="page" placeholder="Page" value="{{ $request->page }}">
                                                </div>
                                                <div class="col-md-2 col-sm-12 col-lg-2">
                                                    <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @if(isset($error))
                                <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3 text-center">
                                    {{ $error }}
                                </div>
                                    @endif
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
                                                <a href="{{ route('quranSurat', $parent_slug) }}" 
                                                   class="thm-btn brd-rd40 mt-2">{{ $parent_surat }}</a>
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
                                    {{-- <div class="col-md-12 w-100">
                                        @if(@$previous)
                                        <div>
                                            <a href="{{ route('search', $previous) }}" class="thm-btn brd-rd40 mt-2 pull-left" type="submit">Previous</a>
                                        </div>
                                        @endif
                                        <div>
                                            @if(isset($parent_surat) && !empty($parent_surat))
                                                <a href="{{ route('quranSurat', $parent_slug) }}" 
                                                   class="thm-btn brd-rd40 mt-2">{{ $parent_surat }}</a>
                                            @else
                                                <!-- Display a default message or link if $parent_surat is not set -->
                                                <a href="#" class="thm-btn brd-rd40 mt-2">No Parent</a>
                                            @endif
                                        </div>
                                        @if(@$next)
                                        <div>
                                            <a href="{{ route('search', $next) }}" class="thm-btn brd-rd40 mt-2 pull-right" type="submit">Next</a>
                                        </div>
                                        @endif
                                    </div> --}}
                                @foreach($search as $child)
                                    <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3 text-center">
                                        <labe>
                                            {{ $child->title }}
                                            <br>
                                            Page - {{ $child->number }}
                                            </small>
                                        </labe>
{{--                                        <a href="{{ asset('/storage/'.$child->image) }}" data-fancybox="gallery" title="">--}}
                                            <br>
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}" width="500px">
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
                                                <a href="{{ route('quranSurat', $parent_slug) }}" 
                                                   class="thm-btn brd-rd40 mt-2">{{ $parent_surat }}</a>
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
    <script !src="">
        var contactFormRow = ($('.contact-form-row').offset().top - 92);

        //===== Sticky =====//
        $(window).on('scroll',function () {
            var scroll = $(window).scrollTop();

            if (scroll >= contactFormRow) {
                $('.contact-form-row').addClass('sticky');
            } else {
                $('.contact-form-row').removeClass('sticky');
            }
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



    </script>
@stop
