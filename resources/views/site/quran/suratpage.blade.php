@extends('site.layout.master')

{{-- @section('title', $surat->title. " - ".$surat->getParent->title) --}}
@section('title', $surat->getParent->title ?? $surat->para_name )


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
                        <h2>{{ $surat->para_name ?? $surat->getParent->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li><a href="{{ route('quranPage') }}" title="">Quran</a></li>
                            <li><a href="{{ route('quranSurat', $surat->getPArent->slug) }}" >{{ $surat->getParent->title }}</a></li>
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
                            
                            <div class="row" >
                                
                                <div class="col-md-12 w-100 text-center" id="stickyFormContainer">
                                    
                                    <div class="d-flex justify-content-between align-items-center">

                                        <!-- Previous Button -->
                                        <div>
                                            @if(@$prev)
                                                <a href="{{ route('quranSurat.page', [$surat->getParent->slug, $prev->number]) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Previous</a>
                                            @endif
                                        </div>
                                        <form id="searchForm" action="{{ route('search') }}">
                                    <div class="row mrg20 justify-content-center align-items-center text-center">
                                        {{-- <div class="col-md-3 col-sm-6 col-lg-3">
                                            <select name="surat">
                                                <option value="">-- Select Surah --</option>
                                                @foreach ($quran as $surat_item)
                                                    <option value="{{ $surat_item->slug }}" {{ $surat_item->id === $surat->id ? 'selected' : '' }}>
                                                        {{ $surat_item->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div> --}}
                                        <div class="col-md-6 col-sm-6 col-lg-3">
                                            <input  type="number" name="page" placeholder="Page No">
                                        </div>
                                        <div class="col-md-2 col-sm-12 col-lg-2">
                                            <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                                    
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('quranSurat.page', [$surat->getParent->slug, $next->number ]) }}" 
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
                                    <img src="{{ asset('storage/'.$surat->image) }}" alt="{{ $surat->title }}" width="100%">
                                </div>
                                {{-- <div class="col-md-12 w-100">
                                    @if(@$prev)
                                        <div>
                                            <a href="{{ route('quranSurat.page', [$surat->getParent->slug, $prev->number]) }}" class="thm-btn brd-rd40 mt-2 pull-left" type="submit">Previous</a>
                                        </div>
                                    @endif
                                    <div>
                                        <a href="{{ route('quranSurat', $surat->getParent->slug) }}" 
                                           class="thm-btn brd-rd40 mt-2">{{ $surat->getParent->title }}</a>
                                    </div>
                                    @if(@$next)
                                        <div>
                                            <a href="{{ route('quranSurat.page', [$surat->getParent->slug, $next->number ]) }}" class="thm-btn brd-rd40 mt-2 pull-right" type="submit">Next</a>
                                        </div>
                                    @endif
                                </div> --}}
                                <div class="col-md-12 w-100 text-center">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if(@$prev)
                                                <a href="{{ route('quranSurat.page', [$surat->getParent->slug, $prev->number]) }}" 
                                                   class="thm-btn brd-rd40 mt-2" 
                                                   type="submit">Previous</a>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            @if(@$next)
                                                <a href="{{ route('quranSurat.page', [$surat->getParent->slug, $next->number ]) }}" 
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