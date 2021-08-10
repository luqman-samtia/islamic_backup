@extends('site.layout.master')

@section('title', 'Quran')

@section('custom_css')
    <style>
        .contact-form > form{
            max-width: none;
        }
        .contact-form > form input, .contact-form > form select, .contact-form > form textarea{
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
                        <h2>Quran</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>Quran</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap" style="padding-top: 20px;">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row contact-form-row">
                                <div class="col-md-12">
                                    <div class="contact-form text-center mb-5">
                                        <form action="{{ route('search') }}">
                                            <div class="row mrg20">
                                                <div class="col-md-4 col-sm-6 col-lg-4">
                                                    <select name="surat">
                                                        <option value="">-- Select Option --</option>
                                                        @foreach($quran as $surat)
                                                            <option value="{{ $surat->slug }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="ayat_from" placeholder="Ayat From">
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="ayat_to" placeholder="Ayat To">
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
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

                            <div class="row">
                                @foreach($quran as $surat)
                                <div class="col-md-3 col-sm-6 col-lg-3">
                                    <div class="srv-box2">
                                        <i class="flaticon-quran-rehal"></i>
                                        <div class="srv-info2">
                                            <h4>{{ $surat->title }}</h4>
                                            <p></p>
                                            <a href="{{ route('quranSurat', $surat->slug) }}" title="">Read More<i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
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
    </script>
@stop
