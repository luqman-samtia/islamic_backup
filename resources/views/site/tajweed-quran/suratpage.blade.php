@extends('site.layout.master')

@section('title', $surat->title. " - ".$surat->getParent->title)

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
                            <li><a href="{{ route('tajweedQuran') }}" title="">Quran</a></li>
                            <li><a href="{{ route('tajweedQuranSurat', $surat->getPArent->slug) }}" >{{ $surat->getParent->title }}</a></li>
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
                                        
                                        <!-- Center Button -->
                                        <div>
                                            <a href="{{ route('tajweedQuranSurat', $surat->getParent->slug) }}" 
                                               class="thm-btn brd-rd40 mt-2">{{ $surat->getParent->title }}</a>
                                        </div>
                                
                                        <!-- Next Button -->
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('tajweedQuranSurat.page', [$surat->getParent->slug, $next->number ]) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Next</a>
                                            @endif
                                        </div>
                                        <form id="searchForm" action="{{ route('tajweedQuranSearch') }}">
                                            <div>    
                                                {{-- thm-btn brd-rd40 mt-3 --}}
                                                    <button type="button" class="thm-btn brd-rd40 pull-right" onclick="openPageModal()">Search</button>
                        
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
                                        <div>
                                            <a href="{{ route('tajweedQuranSurat', $surat->getParent->slug) }}" 
                                               class="thm-btn brd-rd40 mt-2">{{ $surat->getParent->title }}</a>
                                        </div>
                                
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
