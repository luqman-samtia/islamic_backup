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
                        <div class="prtfl-dta remove-ext1">
                            <div class="row mrg15 masonry">
                                @foreach($resource->children as $child)
                                <div class="col-md-2 col-sm-4 col-lg-2 fltr-itm fltr-itm1">
{{--                                    <div class="prtfl-box">--}}
                                    <labe>
                                        {{ $child->title }}
                                    </labe>
                                        <a href="{{ asset('/storage/'.$child->image) }}" data-fancybox="gallery" title="">
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}">
                                        </a>
                                        {{--<div class="prtfl-info">
                                            <i class="fa fa-plus"></i>
                                            <h4>Islamic Center</h4>
                                            <span>artwork / branding</span>
                                        </div>--}}
{{--                                    </div>--}}
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