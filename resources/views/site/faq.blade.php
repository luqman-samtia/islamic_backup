@extends('site.layout.master')

@section('title', 'FAQ')

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
                        <h2>{{ 'FAQ' }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>{{ 'FAQ' }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="container">
                    <div class="sec-title style2 text-center">
                        <div class="sec-title-inner">
                            <h3><span class="secndry-clr">Further</span> Asked Questions</h3>
                        </div>
{{--                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis um voluptatum deleniti atque orrupti quos dolores et quas molestias. Excepturi sint occaecati cupiditate.</p>--}}
                    </div>
                    <div class="srv-wrap3">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="srv-mckp">
                                    <img src="{{ asset('assets/images/resources/srv-img.png') }}" alt="srv-img.png">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12 col-lg-8">
                                <div class="remove-ext5">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>How is the teaching staff?</h4>
                                                </div>
                                                <p>We have tried our best to select most qualified teachers for this holy task. We train each of our teacher for at least one month. They also provide relevant Islamic knowledge to their students. Fully Trusted People are selected for this duty.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>Our Introduction</h4>
                                                </div>
                                                <p>Taleem ul Quran Institute is a world wide Islamic Academy. Its Purpose is to provide online quranic education to the people. This Project was started keeping the people in view who can’t learn Holy Quran due to lack of resources.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>How would online classes take place?</h4>
                                                </div>
                                                <p>Classes will be organised on your desired time. Softwares ( Skype and Gotomeeting ) will be used for the conversation. Screen of Tutor will be viewable by the student by which the lessons will be effective and easy. Online Audio chatting will also held during the same task.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>What you will need?</h4>
                                                </div>
                                                <p>
                                                    You will require following things for online classes
                                                    <ul>
                                                        <li><span dir="ltr">A  computer system / laptop . </span></li>
                                                        <li><span dir="ltr">A  Broadband internet connection </span>DSL/Cable. </li>
                                                        <li><span dir="ltr">A  Microphone and Speakers. </span></li>
                                                        <li><span dir="ltr">Conversational softwares. ( We will guide you ) </span></li>
                                                    </ul>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('site.inc.footer')
    </main>
@stop