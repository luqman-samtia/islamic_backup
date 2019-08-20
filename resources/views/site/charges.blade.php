@extends('site.layout.master')

@section('title', 'Charges')

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
                        <h2>{{ 'Charges' }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>{{ 'Charges' }}</li>
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
                            <h3><span class="secndry-clr">C</span>harges</h3>
                        </div>
                        <p>Charges have been set affordable so that everyone can learn him/herself and can easily provide Holy Quran education to his/her Children. </p>
                    </div>
                    <div class="srv-wrap3" style="direction: ltr">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="srv-mckp">
                                    <img style="width: 200px; top:-20px" src="{{ asset('assets/images/resources/srv-img.png') }}" alt="srv-img.png">
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12 col-lg-8">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Classes / Week</th>
                                        <th>Classes / Month</th>
                                        <th>Classes / Week (USD)</th>
                                        <th>Classes / Week (EURO)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td align="center">2 Classes</td>
                                        <td align="center">8 Classes</td>
                                        <td align="center">30$</td>
                                        <td align="center">30€</td>
                                    </tr>
                                    <tr>
                                        <td align="center">3 Classes</td>
                                        <td align="center">12 Classes</td>
                                        <td align="center">45$</td>
                                        <td align="center">45€</td>
                                    </tr>
                                    <tr>
                                        <td align="center">5 Classes</td>
                                        <td align="center">20 Classes</td>
                                        <td align="center">70$</td>
                                        <td align="center">70€</td>
                                    </tr>
                                    <tr>
                                        <td align="center">6 Classes</td>
                                        <td align="center">24 Classes</td>
                                        <td align="center">80$</td>
                                        <td align="center">80€</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('site.inc.footer')
    </main>
@stop