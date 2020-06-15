@extends('site.layout.master')

@section('title', $surat->title)

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
                        <h2>{{ $surat->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('quranPage') }}" title="">Quran</a></li>
                            <li>{{ $surat->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row">
                                @foreach($surat->children as $child)
                                    <div class="col-md-2 col-sm-6 col-lg-2 fltr-itm fltr-itm1 mb-3">
                                        <labe>
                                            {{ $child->title }}
                                            <br>
                                            Page - {{ $child->number }}
                                            <br>
                                        </labe>
                                        <a href="{{ route('quranSurat.page', [$surat->slug, $child->number]) }}" title="">
                                            <br>
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}">
                                        </a>
                                    </div>
                                @endforeach
                                    <div class="col-md-12 w-100">
                                        @if($prev)
                                            <div>
                                                <a href="{{ route('quranSurat', $prev->slug) }}" class="thm-btn brd-rd40 mt-2 pull-left" type="submit">Previous</a>
                                            </div>
                                        @endif
                                        @if($next)
                                            <div>
                                                <a href="{{ route('quranSurat', $next->slug) }}" class="thm-btn brd-rd40 mt-2 pull-right" type="submit">Next</a>
                                            </div>
                                        @endif
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