@extends('site.layout.master')

@section('title', 'Contact Us')

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
                        <h2>Contact Us</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>Contact Us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="container">
                    <div class="sec-title text-center">
                        <div class="sec-title-inner">
                            <span>Have Question</span>
                            <h3>Send Message</h3>
                        </div>
                        <p>
                            Your Query will be replied in 24 hours at your given email address.<br>
                            Your information will be kept confidential..<br>
{{--                            You can also mail us at <a href="mailto:hafizhabib5651@gmail.com">hafizhabib5651@gmail.com</a>--}}
                        </p>
                    </div>
                    <div class="contact-form text-center">
                        <form method="post" autocomplete="off">
                            @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('success') }}
                                </div>
                            @endif
                            {{-- Rate Limit / General Error --}}
                            @if($errors->has('rate_limit'))
                                <div class="alert alert-danger alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ $errors->first('rate_limit') }}
                                </div>
                            @endif
                            @csrf
                             {{-- Honeypot: CSS se hide karo, JS se nahi (bots JS ignore karte hain) --}}
                                <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true" tabindex="-1">
                                    <label for="website">Leave this empty</label>
                                    <input type="text" name="website" id="website" value="" autocomplete="new-password" tabindex="-1">
                                </div>

                                {{-- Timing token --}}
                                <input type="hidden" name="_form_loaded_at" value="{{ time() }}">
                            <div class="row mrg20">
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <input type="text" name="name" placeholder="Name" required>
                                    @if ($errors->has('name'))
                                        <div class="text-danger" style="font-size: 12px;">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <input type="text" name="phone" placeholder="Phone">
                                </div>
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <input type="email" name="email" placeholder="Email" required>
                                    @if ($errors->has('email'))
                                        <div class="text-danger" style="font-size: 12px;">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-6 col-sm-6 col-lg-6">
                                    <input type="text" name="subject" placeholder="Subject" required>
                                    @if ($errors->has('subject'))
                                        <div class="text-danger" style="font-size: 12px;">{{ $errors->first('subject') }}</div>
                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <textarea placeholder="Message" name="message" minlength="10" required></textarea>
                                    @if ($errors->has('message'))
                                        <div class="text-danger" style="font-size: 12px;">{{ $errors->first('message') }}</div>
                                    @endif
                                    <button class="thm-btn brd-rd40 mt-3" type="submit">Contact Us</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        @include('site.inc.footer')
    </main>
@stop