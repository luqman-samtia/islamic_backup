@extends('site.layout.master')

@section('title', 'Search')

@section('custom_css')
    <style>
        .contact-form > form{
            max-width: none;
        }
        .contact-form > form input, .contact-form > form select, .contact-form > form textarea{
            border: 1px solid #ededed;
        }
    </style>
@stop

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
                        <h2>Search</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>Search</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap" style="padding-top: 20px;">
                <div class="container">
                    <div class="prtfl-wrap">
                        <div class="serv-wrap remove-ext3">
                            <div class="row contact-form-row">
                                <div class="col-md-12">
                                    <div class="contact-form mb-5">
                                        <form id="tajweedSearch" action="{{ route('tajweedQuranSearch') }}">
                                            <div class="row mrg20">
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <select name="surat" >
                                                        <option value="">-- Select Option --</option>
                                                        @foreach($quran as $surat)
                                                            <option {{ $request->surat == $surat->slug ? "selected" : "" }} value="{{ $surat->slug }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="ayat_from" placeholder="Ayat From" value="{{ $request->ayat_from }}">
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="ayat_to" placeholder="Ayat To" value="{{ $request->ayat_to }}">
                                                </div>
                                                <div class="col-md-2 col-sm-6 col-lg-2">
                                                    <input type="number" name="page" placeholder="Page" >
                                                </div>
                                                <div class="col-md-2 col-sm-12 col-lg-2">
                                                    <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                                                </div>
                                                <div class="col-md-2 col-sm-12 col-lg-2">
                                                    <button type="button" class="thm-btn brd-rd40 mt-3"  onclick="openPageModal()"  >Page</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                       <!-- Modal -->
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
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn thm-btn" onclick="confirmPage()">Go to Page</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- JavaScript -->
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
                                        document.getElementById('tajweedSearch').appendChild(input);

                                        // Submit the form
                                        document.getElementById('tajweedSearch').submit();
                                    } else {
                                        alert('Please enter a page number');
                                    }
                                }
                                
                            </script>
                                                            {{-- End Modal --}} 
                                </div>
                            </div>

                            <div class="row">
                                @if(isset($error))
                            <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3 text-center">
                                {{ $error }}
                            </div>
                                @endif
                                <div class="col-md-12 w-100 text-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Previous Button -->
                                        <div>
                                            @if(@$previous)
                                                <a href="{{ route('tajweedQuranSearch', $previous) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Previous</a>
                                            @endif
                                        </div>
                                        
                                        <!-- Center Button -->
                                        <div>
                                            @if($request->surat )
                                            <a href="{{ route('quranSurat', $parent_slug) }}" 
                                               class="thm-btn brd-rd40 mt-4">{{ $parent_surat }}</a>
                                               @endif
                                        </div>
                                
                                        <!-- Next Button -->
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('tajweedQuranSearch', $next ) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Next</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @foreach($search as $child)
                                    <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3 text-center">
                                        <labe>
                                            {{ $child->title }}
                                            <br>
                                            Page - {{ $child->number }}
                                            </small>
                                        </labe>
{{--                                        <a href="{{ asset('/storage/'.$child->image) }}" data-fancybox="gallery" title="">--}}
                                            <br>
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}">
{{--                                        </a>--}}
                                    </div>
                                @endforeach
                                    {{-- <div class="col-md-12 w-100">
                                        @if(@$previous)
                                        <div>
                                            <a href="{{ route('tajweedQuranSearch', $previous) }}" class="thm-btn brd-rd40 mt-2 pull-left" type="submit">Previous</a>
                                        </div>
                                        @endif
                                        @if(@$next)
                                        <div>
                                            <a href="{{ route('tajweedQuranSearch', $next) }}" class="thm-btn brd-rd40 mt-2 pull-right" type="submit">Next</a>
                                        </div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-12 w-100 text-center">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <!-- Previous Button -->
                                            <div>
                                                @if(@$previous)
                                                    <a href="{{ route('tajweedQuranSearch', $previous) }}" 
                                                       class="thm-btn brd-rd40 mt-2" 
                                                       type="submit">Previous</a>
                                                @endif
                                            </div>
                                            
                                            <!-- Center Button -->
                                            <div>
                                                @if($request->surat )
                                                <a href="{{ route('quranSurat', $parent_slug) }}" 
                                                   class="thm-btn brd-rd40 mt-4">{{ $parent_surat }}</a>
                                                   @endif
                                            </div>
                                    
                                            <!-- Next Button -->
                                            <div>
                                                @if(@$next)
                                                    <a href="{{ route('tajweedQuranSearch', $next ) }}" 
                                                       class="thm-btn brd-rd40 mt-2" 
                                                       type="submit">Next</a>
                                                @endif
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
