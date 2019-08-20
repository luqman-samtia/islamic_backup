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
                        <h2> Artical </h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li> Artical </li>
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
                                                <li><i class="fa fa-calendar-o thm-clr"></i>Apr 14, 2019</li>
                                                <li><i class="fa fa-clock-o thm-clr"></i>Tuesday, 9:45 AM</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="blog-detail-desc">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                                        <blockquote class="brd-rd5"><p>
                                                <i class="fa fa-quote-left thm-clr"></i> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                            </p></blockquote>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.</p>
                                        <div class="pst-shr-tgs">
                                            <div class="team-scl float-left">
                                                <span>Share This:</span>
                                                <a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a>
                                                <a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a>
                                                <a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a>
                                                <a href="#" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <div class="sidebar-wrp">
                                    <div class="wdgt-box">
                                        <h4>Recent Posts</h4>
                                        <div class="rcnt-wrp">
                                                <div class="rcnt-inf">
                                                    <h6><a href="blog-detail.html" title="">Lorem ipsum dolor sit</a></h6>
                                                    <span class="thm-clr"><i class="fa fa-calendar-o"></i>June 09, 2019</span>
                                                </div>
                                            <div class="rcnt-inf">
                                                <h6><a href="blog-detail.html" title="">Lorem ipsum dolor sit</a></h6>
                                                <span class="thm-clr"><i class="fa fa-calendar-o"></i>May 25, 2019</span>
                                            </div>
                                            <div class="rcnt-inf">
                                                <h6><a href="blog-detail.html" title="">Lorem ipsum dolor sit</a></h6>
                                                <span class="thm-clr"><i class="fa fa-calendar-o"></i>May 25, 2019</span>
                                            </div>
                                            <div class="rcnt-inf">
                                                <h6><a href="blog-detail.html" title="">Lorem ipsum dolor sit</a></h6>
                                                <span class="thm-clr"><i class="fa fa-calendar-o"></i>May 25, 2019</span>
                                            </div>
                                            <div class="rcnt-inf">
                                                <h6><a href="blog-detail.html" title="">Lorem ipsum dolor sit</a></h6>
                                                <span class="thm-clr"><i class="fa fa-calendar-o"></i>May 25, 2019</span>
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

        @include('site.inc.footer')
    </main>
@stop