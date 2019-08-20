@extends('site.layout.master')

@section('title', 'Terms Of Service')

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
                        <h2>{{ 'Terms Of Service' }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>{{ 'Terms Of Service' }}</li>
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
                            <h3><span class="secndry-clr">Terms</span> Of Service</h3>
                        </div>
{{--                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis um voluptatum deleniti atque orrupti quos dolores et quas molestias. Excepturi sint occaecati cupiditate.</p>--}}
                    </div>
                    <div style="float:left; widows: 100%;">
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
                                                    <h4>Free trial policy:</h4>
                                                </div>
                                                <p>This is 100% FREE and there are no conditions attached. If you are satisfied with the service, You can continue your regular lessons after the free trial.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>eQuranInstitute.com - Refund policy:</h4>
                                                </div>
                                                <p>We have a 100% customer satisfaction policy. If for any reason you are not satisfied simply email info@equraninstitute.com and ask for a refund within 7 days of the invoice. You will receive an acknowledgement within 24 hours. </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>Complaints:</h4>
                                                </div>
                                                <p>Please email your complaints to info@equraninstitute.com - InshaALLAH we will respond within 2 days maximum.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>Cancellation policy:</h4>
                                                </div>
                                                <p>You may cancel your subscription any time.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>Payment of Fee:</h4>
                                                </div>
                                                <p>Fee must be submitted in Advance. Institute Reserves the right to discontinue regular lessons if fee isn't submitted in due date. However, in exceptional cases, where parent assures payment on a future date, Institute can extend their fee submission date. Payment of Fee must be done through our payment processor 2CO. Fee will be received in subscription form where fee will automatically be received on monthly basis. In exceptional cases, Fee can be received through Western Union or Bank Transfer. </p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>Missed Classes and Timing:</h4>
                                                </div>
                                                <p>If you will miss the class by informing the Teacher/Administration, We will be liable to arrange make-up lessons for those missed classes. If you will miss the classes without informing, there will be no make-up lessons for those classes. Kid should come online at his/her class time to take class. If He/She will be late, No extra time will be given.If for any reason, teacher comes late, He/She will be liable to give extra missed time to the kid.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="srv-box3">
                                                <div class="srv-ttl" style="padding: 0px;">
                                                    <h4>Contact details:</h4>
                                                </div>
                                                <p>
                                                    Email us at info@equraninstitute.com or <br>
                                                    Call us at our 24/7 number +92-311-5165709.<br>
                                                    You can also Skype us at equraninstitute.
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