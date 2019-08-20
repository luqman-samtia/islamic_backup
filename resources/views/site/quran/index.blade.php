@extends('site.layout.master')

@section('title', 'Quran')

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
            <div class="gap">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
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