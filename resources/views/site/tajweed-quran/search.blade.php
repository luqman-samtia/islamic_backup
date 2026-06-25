@extends('site.layout.master')

@section('title', 'Search')

@section('custom_css')
    {{-- Select2 CSS (searchable dropdown). Adblock block kare to bhi plain dropdown chalega. --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
        .contact-form > form{
            max-width: none;
        }
        .contact-form > form input, .contact-form > form select, .contact-form > form textarea{
            border: 1px solid #ededed;
        }

        /* sab ek line par, beech mein space, vertically center */
        .search-bar {
            gap: 18px;
        }
        .search-bar select,
        .search-bar input[type="number"] {
            height: 48px !important;
            padding: 0 15px;
            width: auto;
            flex: 0 1 220px;
            margin-top:0px !important;
        }
        /* buttons bhi same height taake line par align rahein */
        .search-bar .thm-btn {
            height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-top: 0 !important;
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

        /* --- Select2 theming to match existing form inputs --- */
        .search-bar .select2-container {
            flex: 0 1 220px;
            width: 220px !important;
        }
        .select2-container .select2-selection--single {
            height: 48px !important;
            border: 1px solid #ededed;
            display: flex;
            align-items: center;
            padding: 0 8px;
            border-radius: 4px;
            margin-bottom:10px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal;
            color: #333;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #c79f1a;
        }
        .select2-dropdown {
            border: 1px solid #ededed;
        }

        /* Mobile: select2 bhi full width */
        @media (max-width: 575px) {
            .search-bar .select2-container {
                flex: 1 1 100%;
                width: 100% !important;
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

                            <div class="row contact-form-row">
                                    <div class="col-md-12" id="stickyFormContainer">
                                        <div class="contact-form mb-5">
                                            <form id="tajweedSearch" action="{{ route('tajweedQuranSearch') }}">
                                                <div class="search-bar d-flex flex-wrap justify-content-center align-items-center text-center mrg20">

                                                    @if(@$previous)
                                                        <a href="{{ route('tajweedQuranSearch', $previous) }}" class="thm-btn brd-rd40">Previous</a>
                                                    @endif

                                                    <select name="surat" id="tajweed-surah-select">
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
                                                    <a href="{{ route('tajweedQuranSearch', $previous) }}" 
                                                       class="thm-btn brd-rd40 mt-2" 
                                                       type="submit">Previous</a>
                                                @endif
                                            </div>

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

    {{-- Self-loading: jQuery -> Select2 -> init. Adblock/slow network ho ya jQuery footer mein ho, error nahi aayega. --}}
    <script>
        (function () {
            function loadScript(src, cb) {
                var s = document.createElement('script');
                s.src = src;
                s.onload = cb;
                s.onerror = function () { console.warn('Failed to load: ' + src); cb(); };
                document.head.appendChild(s);
            }

            function ensureJQuery(next) {
                if (window.jQuery) { next(); return; }
                // Project ki local jQuery pehle (adblock isko block nahi karta), warna CDN
                loadScript("{{ asset('assets/js/jquery.min.js') }}", function () {
                    if (window.jQuery) { next(); }
                    else { loadScript('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', next); }
                });
            }

            function ensureSelect2(next) {
                if (window.jQuery && jQuery.fn && jQuery.fn.select2) { next(); return; }
                loadScript('https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', function () {
                    // Plugin attach hone ka intezaar karo (kabhi onload ke baad bhi 1 tick lagta hai)
                    var tries = 0;
                    (function waitForSelect2() {
                        if (window.jQuery && jQuery.fn && jQuery.fn.select2) {
                            next();
                        } else if (tries < 50) {
                            tries++;
                            setTimeout(waitForSelect2, 50);
                        } else {
                            console.warn('Select2 load hone mein der ho gayi.');
                            next();
                        }
                    })();
                });
            }

            function init() {
                var $ = window.jQuery;
                var hasSelect2 = !!($ && $.fn && $.fn.select2);

                //===== Sticky =====//
                var contactFormRow = ($('.contact-form-row').offset().top - 92);
                $(window).on('scroll', function () {
                    var scroll = $(window).scrollTop();
                    if (scroll >= contactFormRow) {
                        $('.contact-form-row').addClass('sticky');
                    } else {
                        $('.contact-form-row').removeClass('sticky');
                    }
                });

                //===== Select2 init (searchable surah dropdown) =====//
                if (hasSelect2) {
                    $('#tajweed-surah-select').select2({
                        placeholder: '-- Select Option --',
                        allowClear: true,
                        width: '220px'
                    });
                } else {
                    console.warn('Select2 not available - plain dropdown will be used.');
                }

                //===== Surah change -> us surat ke pehle page par jao =====//
                $('#tajweed-surah-select').on('change', function () {
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

                //===== Form submit guard: page aur surat dono khali ho to submit na ho =====//
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
            }

            // Chain: jQuery -> Select2 -> init
            ensureJQuery(function () {
                ensureSelect2(function () {
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', init);
                    } else {
                        init();
                    }
                });
            });
        })();
    </script>
@stop