@extends('site.layout.master')

@section('title', 'Para ' . $para_name)

@section('custom_css')
    <style>
        .contact-form-row.sticky .mb-lg-5{
            margin-bottom: 15px !important;
        }
        .contact-form-row.sticky{
            left: 0px;
        }
    </style>
@stop

@section('content')
    <main>
        @include('site.inc.loader')
        @include('site.inc.header')
        @include('site.inc.header_responsive')

            <!-- Modal -->
            <div class="modal fade" id="pageModal" tabindex="-1" role="dialog" aria-labelledby="pageModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="pageModalLabel">Go to Page</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="number" id="pageInput" placeholder="Enter page number" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn thm-btn" onclick="confirmPage()">Go to Page</button>
                        </div>
                    </div>
                </div>
            </div>

        <section>
            <div class="gap remove-bottom black-layer2 opc85">
                <div class="fixed-bg" style="background-image: url('{{ asset('assets/images/parallax12.jpg') }}');"></div>
                <div class="container">
                    <div class="page-title-wrap">
                        <h2> {{ $para_name }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('quranPage') }}" title="">Quran</a></li>
                            <li> {{ $para_name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="mt-lg-5">
                <div class="col-md-12 w-100 contact-form-row" id="stickyFormContainer">
                    <form id="searchForm" action="{{ route('search') }}">
                        <div class="row mrg20 justify-content-center align-items-center text-center">
                            <!-- Para Select - Populated from PHP -->
                            <div id="para-select-container" class="col-md-3 col-sm-6 col-lg-3">
                                <select name="para" id="para-select" onchange="changeParaPage(this.value)">
                                    <option value="">-- Select Para --</option>
                                    @foreach($allParas as $para)
                                        <option value="{{ $para['para_no'] }}" {{ $para['para_no'] == $para_no ? 'selected' : '' }}>
                                            {{ $para['para_name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- Page Input -->
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <input type="number" name="page" placeholder="Page">
                            </div>
                            <!-- Search Button -->
                            <div class="col-md-2 col-sm-12 col-lg-2">
                                <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row mb-lg-5">
                                @foreach($pages as $page)
                                    <div class="col-md-2 col-sm-6 col-lg-2 fltr-itm fltr-itm1 mb-3">
                                        <labe>
                                            <br>
                                            Page - {{ $page->number }}
                                            <br>
                                        </labe>
                                        <a href="{{ route('quranSurat.page', [$page->getParent->slug, $page->number]) }}" title="">
                                            <br>
                                            <img src="{{ asset('storage/'.$page->image) }}" alt="Page {{ $page->number }}" >
                                        </a>
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

<script>
     function changeParaPage(paraNo) {
            if (paraNo) {
                window.location.href = "{{ route('quran.para', '') }}/" + paraNo;
            }
        }
</script>
@section('custom_js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            var contactFormRow = ($('.contact-form-row').offset().top - 92);

            $(window).on('scroll', function () {
                var scroll = $(window).scrollTop();

                if (scroll >= contactFormRow) {
                    $('.contact-form-row').addClass('sticky');
                } else {
                    $('.contact-form-row').removeClass('sticky');
                }
            });
        });

        // Function to change para
       
    </script>
@stop