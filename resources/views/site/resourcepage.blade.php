@extends('site.layout.master')

@section('title', $resource->title)

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
                        <h2>{{ $resource->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('page', $resource->getPArent->slug) }}" >{{ $resource->getParent->title }}</a></li>
                            <li>{{ $resource->title }}</li>
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
                                <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3">
                                    <labe>
                                        {{ $resource->title }}
                                        <br>
                                    </labe>
                                    <img src="{{ asset('/storage/'.$resource->image) }}" alt="{{ $resource->title }}">
                                </div>
                                <div class="col-md-12 w-100">
                                    @if(@$prev)
                                        <div>
                                            <a href="{{ route('quranSurat.page', [$resource->getParent->slug, $prev->number]) }}" class="thm-btn brd-rd40 mt-2 pull-left" type="submit">Previous</a>
                                        </div>
                                    @endif
                                    @if(@$next)
                                        <div>
                                            <a href="{{ route('quranSurat.page', [$resource->getParent->slug, $next->number ]) }}" class="thm-btn brd-rd40 mt-2 pull-right" type="submit">Next</a>
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