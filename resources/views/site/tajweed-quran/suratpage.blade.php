@extends('site.layout.master')

{{-- @section('title', 'para-'.$surat->para_no. " - ".$surat->getParent->title) --}}
@section('title', $surat->para_name ?? $surat->title)

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
                        <input type="number" id="pageInput" placeholder="Enter Page No" class="form-control">
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
                        <h2>{{ $surat->para_name ?? $surat->getParent->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('tajweedQuran') }}" title="">Tajweed Quran 16</a></li>
                            <li><a href="{{ route('tajweedQuranSurat', $surat->getParent->slug) }}" >{{ $surat->getParent->title }}</a></li>
                            <li>Page - {{ $surat->number }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            <div class="row">
                                <div class="col-md-12 w-100 text-center" id="stickyFormContainer">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Previous Button -->
                                        <div>
                                            @if(@$prev)
                                                <a href="{{ route('tajweedQuranSurat.page', [$surat->getParent->slug, $prev->number]) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Previous</a>
                                            @endif
                                        </div>
                                        <form id="searchForm" action="{{ route('tajweedQuranSearch') }}">
                                            <div class="d-flex justify-content-center align-items-center flex-wrap" style="gap: 15px;"> 
                                                <div>
                                                    <input type="number" name="page" placeholder="Enter Page No" style="margin-bottom: 0; width: 200px; height: 45px; padding: 10px 20px; border: 1px solid #e1e1e1;">
                                                </div>
                                                <div>
                                                    <button class="thm-btn brd-rd40 search-btn-small" type="submit" style="margin-top: 0;">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                      
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('tajweedQuranSurat.page', [$surat->getParent->slug, $next->number ]) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Next</a>
                                            @endif
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-lg-12 fltr-itm fltr-itm1 mb-3">
                                    <labe>
                                        {{-- {{ $surat->title }} --}}
                                        <br>
                                        Page - {{ $surat->number }}
                                        <br>
                                    </labe>
                                    <img src="{{ asset('/storage/'.$surat->image) }}" alt="{{ $surat->title }}" width="100%">
                                </div>
                                <div class="col-md-12 w-100 text-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <!-- Previous Button -->
                                        <div>
                                            @if(@$prev)
                                                <a href="{{ route('tajweedQuranSurat.page', [$surat->getParent->slug, $prev->number]) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Previous</a>
                                            @endif
                                        </div>
                                        
                                        <!-- Center Button -->
                                        {{-- <div>
                                            <a href="{{ route('tajweedQuranSurat', $surat->getParent->slug) }}" 
                                               class="thm-btn brd-rd40 mt-2">{{ $surat->getParent->title }}</a>
                                        </div> --}}
                                
                                        <!-- Next Button -->
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('tajweedQuranSurat.page', [$surat->getParent->slug, $next->number ]) }}" 
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
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
        });
    </script>
@endif
 @if(Session::has('message'))
    toastr.success("{{ Session::get('message') }}");
    @endif

    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif