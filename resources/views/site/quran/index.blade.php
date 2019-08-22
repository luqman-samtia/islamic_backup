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
                            <div class="d-flex pb-5">
                                    <div class="form-group col-md-2.5 pr-3">
                                        <input type="text" name="title" class="form-control" placeholder="Enter Surah Title" >
                                    </div>
                                    <div class="form-group col-md-2.5 pl-3 pr-3">
                                        <input type="number" name="ayat_from" min="1" class="form-control" placeholder="Ayat From " >
                                    </div>
                                    <div class="form-group col-md-2.5 pr-3 pl-3">
                                        <input type="number" name="ayat_to" min="1" class="form-control" placeholder="Ayat To " >
                                    </div>
                                    <div class="form-group col-md-2.5 pl-3 pr-3">
                                        <input type="number" name="number" min="1" class="form-control" placeholder="Enter Page Number" >
                                    </div>
                                    <div class="form-group col-md-2 pl-5">
{{--                                        <a class="thm-btn brd-rd40" href="#" title="">Search</a>--}}
                                        <button type="button" class="btn btn-block" style="background-color: #E7C860;color: white;">Search</button>
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