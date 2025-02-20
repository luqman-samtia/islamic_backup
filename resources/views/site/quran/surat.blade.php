@extends('site.layout.master')

@section('title', $surat->title)

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
                            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
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
                        <h2>{{ $surat->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('quranPage') }}" title="">Quran</a></li>
                            <li>{{ $surat->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="mt-lg-5">
                <div class="col-md-12 w-100 contact-form-row" id="stickyFormContainer">
                    @if($prev)
                        <div>
                            <a href="{{ route('quranSurat', $prev->slug) }}" class="thm-btn brd-rd40 mb-lg-5 pull-left" type="submit">Previous</a>
                        </div>
                    @endif
                    @if($next)
                        <div>
                            <a href="{{ route('quranSurat', $next->slug) }}" class="thm-btn brd-rd40 mb-lg-5 pull-right" type="submit">Next</a>
                        </div>
                    @endif
                    <form id="searchForm" action="{{ route('search') }}">
                        <div>    
                            {{-- thm-btn brd-rd40 mt-3 --}}
                                <button type="button" class="thm-btn brd-rd40 mb-lg-5 pull-right" onclick="openPageModal()">Page</button>

                        </div>
                        <script>
    function openPageModal() {
        $('#pageModal').modal('show')
        .on('shown.bs.modal', function () {
            // Add and remove classes once the modal is fully shown
            $('.modal-backdrop').remove();
        });
    }
        function confirmPage() {
        var pageNumber = document.getElementById('pageInput').value;
        if (pageNumber) {
            // Set the page input in the form
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'page';
            input.value = pageNumber;
            document.getElementById('searchForm').appendChild(input);

            // Submit the form
            document.getElementById('searchForm').submit();
        } else {
            alert('Please enter a page number');
        }
    }
  
                        </script>
                    </form>
                </div>
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row mb-lg-5">
                                @foreach($surat->children as $child)
                                    <div class="col-md-2 col-sm-6 col-lg-2 fltr-itm fltr-itm1 mb-3">
                                        <labe>
                                            {{ $child->title }}
                                            <br>
                                            Page - {{ $child->number }}
                                            <br>
                                        </labe>
                                        <a href="{{ route('quranSurat.page', [$surat->slug, $child->number]) }}" title="">
                                            <br>
                                            <img src="{{ asset('storage/'.$child->image) }}" alt="{{ $child->title }}" >
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

@section('custom_js')
    <script !src="">
        var contactFormRow = ($('.contact-form-row').offset().top - 92);

        //===== Sticky =====//
        $(window).on('scroll',function () {
            var scroll = $(window).scrollTop();

            if (scroll >= contactFormRow) {
                $('.contact-form-row').addClass('sticky');
            } else {
                $('.contact-form-row').removeClass('sticky');
            }
        });


   
    

                            
    </script>
@stop
