@extends('site.layout.master')

@section('title', $para_name)

@section('custom_css')
    {{-- Select2 CSS (searchable dropdown). Adblock block kare to bhi plain dropdown chalega. --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
        .contact-form-row.sticky .mb-lg-5{
            margin-bottom: 15px !important;
        }
        .contact-form-row.sticky{
            left: 0px;
        }

        /* --- Select2 theming to match existing form inputs --- */
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 48px;
            border: 1px solid #ededed;
            display: flex;
            align-items: center;
            padding: 0 8px;
            border-radius: 4px;
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
    </style>
@stop

@section('content')
    <main>
        @include('site.inc.loader')
        @include('site.inc.header')
        @include('site.inc.header_responsive')

            <!-- Modal -->
            <div class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pageModalLabel">Go to Page</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="number" id="pageInput" placeholder="Enter page number" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn thm-btn" onclick="confirmPage()">Go to Page</button>
                        </div>
                    </div>
                </div>
            </div>

        <section>
            <div class="gap remove-bottom black-layer2 opc85">
                <div class="fixed-bg" style="background-image: url('{{ asset('assets/images/parallax12.jpg') }}');"></div>
                <div class="container">
                    <div class="page-title-wrap">
                        <h2> {{ $para_name }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('tajweedQuran') }}" title="">Tajweed Quran 16</a></li>
                            <li> {{ $para_name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="mt-lg-5">
                <div class="col-md-12 w-100 contact-form-row" id="stickyFormContainer">
                    <form id="searchForm" action="{{ route('tajweedQuranSearch') }}">
                        <div class="row mrg20 justify-content-center align-items-center text-center">
                            <!-- Para Select - Populated from PHP -->
                            <div id="para-select-container" class="col-md-3 col-sm-6 col-lg-3">
                                <select name="para" id="para-select">
                                    <option value="">-- Select Para --</option>
                                    @foreach($allParas as $para)
                                        <option value="{{ $para['para_no'] }}" data-first="{{ $para['first_page'] ?? '' }}" {{ $para['para_no'] == $para_no ? 'selected' : '' }}>
                                            {{ $para['para_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Page Input -->
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <input type="number" name="page" placeholder="Enter Page No">
                            </div>
                            <!-- Search Button -->
                            <div class="col-md-2 col-sm-12 col-lg-2">
                                <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row mb-lg-5">
                                @foreach($pages as $page)
                                    <div class="col-md-2 col-sm-6 col-lg-2 fltr-itm fltr-itm1 mb-3">
                                        <labe>
                                            <br>
                                            Page - {{ $page->number }}
                                            <br>
                                        </labe>
                                        <a href="{{ route('tajweedQuranSurat.page', [$page->getParent->slug, $page->number]) }}" title="">
                                            <br>
                                            <img src="{{ asset('storage/'.$page->image) }}" alt="Page {{ $page->number }}" >
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('site.inc.footer')
    </main>
@stop

<script>
     function changeParaPage(paraNo) {
            if (paraNo) {
                window.location.href = "{{ route('tajweedQuran.para', '') }}/" + paraNo;
            }
        }
</script>
{{-- @section('custom_js') --}}
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
                loadScript('https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', next);
            }

            function init() {
                var $ = window.jQuery;
                var hasSelect2 = !!($ && $.fn && $.fn.select2);

                //===== Sticky Form =====//
                var contactFormRow = ($('.contact-form-row').offset().top - 92);
                $(window).on('scroll', function () {
                    var scroll = $(window).scrollTop();
                    if (scroll >= contactFormRow) {
                        $('.contact-form-row').addClass('sticky');
                    } else {
                        $('.contact-form-row').removeClass('sticky');
                    }
                });

                //===== Select2 init (searchable para dropdown) =====//
                if (hasSelect2) {
                    $('#para-select').select2({
                        placeholder: '-- Select Para --',
                        allowClear: true,
                        width: '100%'
                    });
                } else {
                    console.warn('Select2 not available - plain dropdown will be used.');
                }

                //===== Para change -> us para ke pehle page par jao (jaise surah mein) =====//
                $('#para-select').on('change', function () {
                    if (!this.value) { return; }
                    var first = this.options[this.selectedIndex].getAttribute('data-first');
                    if (first) {
                        window.location.href = "{{ route('tajweedQuranSurat.page', ['__SLUG__','__PAGE__']) }}"
                            .replace('__SLUG__', 'para-' + this.value)
                            .replace('__PAGE__', first);
                    } else {
                        window.location.href = "{{ route('tajweedQuran.para', '') }}/" + this.value;
                    }
                });
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
{{-- @stop --}}