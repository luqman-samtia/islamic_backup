@extends('site.layout.master')

@section('title', $surat->para_name ?? $surat->title)

@section('custom_css')
    <style>
        .contact-form>form {
            max-width: none;
        }

        .contact-form>form input,
        .contact-form>form select,
        .contact-form>form textarea {
            border: 1px solid #ededed;
        }

        .contact-form-row.sticky .mb-lg-5{
            margin-bottom: 15px !important;
        }
        .contact-form-row.sticky{
            left: 0px;
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
                            <li><a href="{{ route('quranPage') }}" title="">Quran</a></li>
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
                                            <select name="surat">
                                                <option value="">-- Select Surah --</option>
                                                @foreach ($quran as $surat_item)
                                                    <option value="{{ $surat_item->slug }}" {{ $surat_item->id === $surat->id ? 'selected' : '' }}>
                                                        {{ $surat_item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-lg-3">
                                            <input type="number" name="page" placeholder="Page">
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
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
@stop

@section('custom_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var contactFormRow = ($('.contact-form-row').offset().top - 92);

            //===== Sticky Form =====//
            $(window).on('scroll', function () {
                var scroll = $(window).scrollTop();

                if (scroll >= contactFormRow) {
                    $('.contact-form-row').addClass('sticky');
                } else {
                    $('.contact-form-row').removeClass('sticky');
                }
            });
        });
    </script>
@stop