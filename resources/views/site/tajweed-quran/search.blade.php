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
        .contact-form > form{
            max-width: none;
        }
        .contact-form > form input, .contact-form > form select, .contact-form > form textarea{
            border: 1px solid #ededed;
        }

        /* sab ek line par, beech mein space */
        .search-bar {
            gap: 18px;
        }
        .search-bar select,
        .search-bar input[type="number"] {
            height: 48px;
            padding: 0 15px;
            width: auto;
            flex: 0 1 220px;
        }

        /* Tablet */
        @media (max-width: 991px) {
            .search-bar { gap: 14px; }
        }

        /* Mobile: sab full width */
        @media (max-width: 575px) {
            .search-bar {
                gap: 12px;
                flex-direction: column;
            }
            .search-bar > *,
            .search-bar select,
            .search-bar input[type="number"] {
                width: 100%;
                flex: 1 1 100%;
            }
        }
    </style>
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
                            {{-- <div class="row contact-form-row">
                                <div class="col-md-12" id="stickyFormContainer">
                                    <div class="contact-form mb-5"  >
                                        <form id="tajweedSearch" action="{{ route('tajweedQuranSearch') }}">
                                            <div class="row mrg20 justify-content-center align-items-center text-center">
                                                <div class="col-md-3 col-sm-6 col-lg-3">
                                                    <select name="surat" onchange="this.form.submit()">
                                                        <option value="">-- Select Option --</option>
                                                        @foreach($quran as $surat)
                                                            <option {{ $request->surat == $surat->slug ? "selected" : "" }} value="{{ $surat->slug }}" data-first="{{ $surat->first_page }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-3 col-sm-6 col-lg-3">
                                                    <input type="number" name="page" placeholder="Enter Page No" >
                                                </div>
                                                <div class="col-md-3 col-sm-12 col-lg-3">
                                                    <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                                         
                                </div>
                            </div> --}}

                            <div class="row contact-form-row">
                                    <div class="col-md-12" id="stickyFormContainer">
                                        <div class="contact-form mb-5">
                                            <form id="tajweedSearch" action="{{ route('tajweedQuranSearch') }}">
                                                <div class="search-bar d-flex flex-wrap justify-content-center align-items-center text-center mrg20">

                                                    @if(@$previous)
                                                        <a href="{{ route('tajweedQuranSearch', $previous) }}" class="thm-btn brd-rd40">Previous</a>
                                                    @endif

                                                    <select name="surat" onchange="this.form.submit()">
                                                        <option value="">-- Select Option --</option>
                                                        @foreach($quran as $surat)
                                                            <option {{ $request->surat == $surat->slug ? "selected" : "" }} value="{{ $surat->slug }}" data-first="{{ $surat->first_page }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>

                                                    <input type="number" name="page" placeholder="Enter Page No">

                                                    <button class="thm-btn brd-rd40" type="submit">Search</button>

                                                    @if(@$next)
                                                        <a href="{{ route('tajweedQuranSearch', $next) }}" class="thm-btn brd-rd40" type="submit">Next</a>
                                                    @endif

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
                                {{-- <div class="col-md-12 w-100 text-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if(@$previous)
                                                <a href="{{ route('tajweedQuranSearch', $previous) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Previous</a>
                                            @endif
                                        </div>
                                                                        
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('tajweedQuranSearch', $next ) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Next</a>
                                            @endif
                                        </div>
                                    </div>
                                </div> --}}
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
                                    {{-- <div class="col-md-12 w-100">
                                        @if(@$previous)
                                        <div>
                                            <a href="{{ route('tajweedQuranSearch', $previous) }}" class="thm-btn brd-rd40 mt-2 pull-left" type="submit">Previous</a>
                                        </div>
                                        @endif
                                        @if(@$next)
                                        <div>
                                            <a href="{{ route('tajweedQuranSearch', $next) }}" class="thm-btn brd-rd40 mt-2 pull-right" type="submit">Next</a>
                                        </div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-12 w-100 text-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Previous Button -->
                                            <div>
                                                @if(@$previous)
                                                    <a href="{{ route('tajweedQuranSearch', $previous) }}" 
                                                       class="thm-btn brd-rd40 mt-2" 
                                                       type="submit">Previous</a>
                                                @endif
                                            </div>
                                            
                                            <!-- Center Button -->
                                            {{-- <div>
                                                @if($parent_slug)
                                                <a href="{{ route('tajweedQuranSurat', $parent_slug) }}" 
                                                   class="thm-btn brd-rd40 mt-4">{{ $parent_surat }}</a>
                                                   @endif
    
                                            </div>
                                     --}}
                                            <!-- Next Button -->
                                            <div>
                                                @if(@$next)
                                                    <a href="{{ route('tajweedQuranSearch', $next ) }}" 
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
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
@endif
 @if(Session::has('message'))
    toastr.success("{{ Session::get('message') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
{{-- @stop --}}

{{-- @section('custom_js') --}}
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

        var tjSuratSelect = document.getElementById('tajweedSuratSelect');
if (tjSuratSelect) {
    tjSuratSelect.addEventListener('change', function () {
        if (!this.value) { return; }
        var first = this.options[this.selectedIndex].getAttribute('data-first');
        if (first) {
            window.location.href = "{{ route('tajweedQuranSurat.page', ['__SLUG__','__PAGE__']) }}"
                .replace('__SLUG__', this.value)
                .replace('__PAGE__', first);
        } else {
            window.location.href = "{{ route('tajweedQuranSurat', '') }}/" + this.value;
        }
    });
}

var tjForm = document.getElementById('tajweedSearch');
if (tjForm) {
    tjForm.addEventListener('submit', function (e) {
        var pageVal  = (tjForm.querySelector('input[name="page"]') || {}).value || '';
        var suratVal = (tjForm.querySelector('select[name="surat"]') || {}).value || '';
        if (!pageVal.trim() && !suratVal) {
            e.preventDefault();
        }
    });
}
    </script>
@stop
