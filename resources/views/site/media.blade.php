@extends('site.layout.master')

@section('title', $islamicmedia->title)

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
                        <h2>{{ $islamicmedia->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>{{ $islamicmedia->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class=" mt-5 mb-">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="prtfl-dta remove-ext1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="contact-form text-center mb-5">
                                        <form action="">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6">
                                                    <input type="text" name="q" placeholder="Search" value="{{ request()->q }}">
                                                </div>
                                                <div class="col-md-6 col-sm-6">
                                                    <button class="thm-btn brd-rd40 mt-3 pull-right" type="submit">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg15 masonry">
                                @foreach($islamicmedia->children as $child)
                                <div class="col-md-4 col-sm-12 col-lg-4 fltr-itm fltr-itm1 mb-4 text-center">
                                    <label class="mb-3">
                                        {!! str_limit(strip_tags($child->title),40) !!}
                                        <br>
                                    </label>
                                    <iframe width="400" height="250" allowfullscreen="allowfullscreen"
                                            src="https://www.youtube.com/embed/{{ $child->youtube_id }}">
                                    </iframe>
                                    <p class="mt-3">
                                        {!! str_limit(strip_tags($child->description),140) !!}
                                    <br>
                                    </p>
                                    <br>
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