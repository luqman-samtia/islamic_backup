@extends('site.layout.master')

@section('title', $surat->para_name ?? $surat->title)

@section('custom_css')
    {{-- Select2 CSS (searchable dropdown). Adblock block kare to bhi plain dropdown chalega. --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
        .contact-form>form {
            max-width: none;
        }

        .contact-form>form input,
        .contact-form>form select,
        .contact-form>form textarea {
            border: 1px solid #ededed;
        }
        #searchForm input[type="number"] {
                height: 48px !important;
                margin-top :0px !important;
            }

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
                        <h2>{{ $surat->para_name ?? $surat->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('quranPage') }}" title="">Tajweed Quran 15</a></li>
                            <li>{{ $surat->para_name ?? $surat->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="gap" style="padding-top: 20px;">
                <div class="container">
                    {{-- Search Form from Index --}}
                    <div class="row contact-form-row" id="stickyFormContainer">
                        <div class="col-md-12">
                            <div class="contact-form text-center mb-5">
                                <form id="searchForm" action="{{ route('search') }}">
                                    <div class="row mrg20 justify-content-center align-items-center text-center">
                                        <div class="col-md-3 col-sm-6 col-lg-3">
                                            <select name="surat" id="surah-select">
                                                <option value="">-- Select Surah --</option>
                                                @foreach ($quran as $surat_item)
                                                    <option value="{{ $surat_item->slug }}" data-first="{{ $surat_item->first_page }}" {{ $surat_item->id === $surat->id ? 'selected' : '' }}>
                                                        {{ $surat_item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-lg-3">
                                            <input type="number" name="page" placeholder=" Enter Page No">
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <button class="thm-btn brd-rd40 " type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            {{-- Navigation Buttons --}}
                            {{-- <div class="row mb-3">
                                <div class="col-md-12">
                                    @if($prev)
                                        <a href="{{ route('quranSurat', $prev->slug) }}" class="thm-btn brd-rd40" type="submit">← Previous</a>
                                    @endif
                                    @if($next)
                                        <a href="{{ route('quranSurat', $next->slug) }}" class="thm-btn brd-rd40" type="submit">Next →</a>
                                    @endif
                                </div>
                            </div> --}}

                            {{-- Surat Pages --}}
                            <div class="row mb-lg-5">
                                @foreach($surat->children as $child)
                                    <div class="col-md-2 col-sm-6 col-lg-2 fltr-itm fltr-itm1 mb-3">
                                        <label>
                                            Page - {{ $child->number }}
                                        </label>
                                        <a href="{{ route('quranSurat.page', [$surat->slug, $child->number]) }}" title="">
                                            <br>
                                            <img src="{{ asset('storage/'.$child->image) }}" alt="{{ $child->title }}">
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
{{-- @stop --}}

{{-- @section('custom_js') --}}
    {{-- Self-loading: Select2 ko load karta hai, ready hone par init hota hai.
         jQuery footer/head kahin bhi ho ya adblock ho, error nahi aayega. --}}
    <script>
        (function () {
            function loadScript(src, cb) {
                var s = document.createElement('script');
                s.src = src;
                s.onload = cb;
                s.onerror = function () { console.warn('Failed to load: ' + src); cb(); };
                document.head.appendChild(s);
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

                //===== Select2 init (searchable surah dropdown) =====//
                if (hasSelect2) {
                    $('#surah-select').select2({
                        placeholder: '-- Select Surah --',
                        allowClear: true,
                        width: '100%'
                    });
                } else {
                    console.warn('Select2 not available - plain dropdown will be used.');
                }

                //===== Surah change -> us surat ke pehle page par jao =====//
                $('#surah-select').on('change', function () {
                    if (!this.value) { return; }
                    var first = this.options[this.selectedIndex].getAttribute('data-first');
                    if (first) {
                        window.location.href = "{{ route('quranSurat.page', ['__SLUG__','__PAGE__']) }}"
                            .replace('__SLUG__', this.value).replace('__PAGE__', first);
                    } else {
                        window.location.href = "{{ route('quranSurat', '') }}/" + this.value;
                    }
                });
            }

            // Chain: Select2 load -> init (jQuery already project mein maujood maan kar)
            ensureSelect2(function () {
                if (window.jQuery) {
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', init);
                    } else {
                        init();
                    }
                } else {
                    console.warn('jQuery not found - sticky form & select2 skipped.');
                }
            });
        })();
    </script>
@stop