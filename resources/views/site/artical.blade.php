@extends('site.layout.master')

@section('title', $artical->title)

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
                        <h2> Article </h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li> Article </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="container">
                    <div class="blog-detail-wrp">
                        <div class="row">
                            <div class="col-md-9 col-sm-12 col-lg-9">
                                <div class="blog-detail">
                                    <div class="blog-detail-inf brd-rd5">
                                        <div class="blog-detail-inf-inr">
                                            <h4>{{ $artical->title }}</h4>
                                            <ul class="pst-mta">
                                                <li><i class="fa fa-calendar-o thm-clr"></i>{{ date('F d, Y',strtotime($artical->created_at)) }}</li>
                                                <li><i class="fa fa-clock-o thm-clr"></i>{{ date('l, g:i A',strtotime($artical->created_at)) }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="blog-detail-desc">
                                        <p>{!!  $artical->content  !!}</p>
{{--                                        <div class="pst-shr-tgs">--}}
{{--                                            <div class="team-scl float-left">--}}
{{--                                                <span>Share This:</span>--}}
{{--                                                <a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>--}}
{{--                                                <a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>--}}
{{--                                                <a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>--}}
{{--                                                <a href="#" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <div class="sidebar-wrp">
                                    <div class="wdgt-box">
                                        <h4>Recent Posts</h4>
                                        <div class="rcnt-wrp">
                                            @foreach($posts as $post)
                                                <div class="rcnt-inf">
                                                    <h6><a href="#" title="">{{ $post->title }}</a></h6>
                                                    <span class="thm-clr"><i class="fa fa-calendar-o"></i>{{ date('F d, Y',strtotime($post->created_at)) }}</span>
                                                </div>
                                                @endforeach
                                        </div>
                                    </div>
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