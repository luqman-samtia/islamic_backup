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
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="contact-form text-center mb-5">
                                        <form action="{{ route('search') }}">
                                            <div class="row mrg20">
                                                <div class="col-md-4 col-sm-6 col-lg-4">
                                                    <select name="surat" required>
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
                                @foreach($search as $child)
                                    <div class="col-md-2 col-sm-4 col-lg-2 fltr-itm fltr-itm1">
                                        <labe>
                                            {{ $child->title }}
                                        </labe>
                                        <a href="{{ asset('/storage/'.$child->image) }}" data-fancybox="gallery" title="">
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}">
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