@extends('site.layout.master')

@section('title', $resource->title)

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
                        <h2>{{ $resource->title }}</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>{{ $resource->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class=" mt-5 mb-">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="prtfl-dta remove-ext1">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <div class="contact-form text-center mb-5">
                                       <form action="" style="max-width: 100% !important;">
                                            <div class="d-flex flex-wrap align-items-center mb-4" id="stickyFormContainer" style="justify-content: space-evenly;">                                                
                                                @if($prev)
                                                    <div>
                                                        <a href="{{ route('page', [$resource->slug, 'page' => $prev->number]) }}" class="thm-btn brd-rd40 m-0" style="height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0 25px; box-sizing: border-box; text-decoration: none;">Previous</a>
                                                    </div>
                                                @endif

                                                <div>
                                                    <select name="takhti" class="form-control w-100" 
                                                        style="width: 180px; height: 45px; padding: 0 15px; border: 1px solid #e1e1e1; 
                                                            margin: 0; box-sizing: border-box; text-align: center; border-radius: 0;">
                                                        
                                                        <option value="">-- Mazoon --</option>
                                                        
                                                        @foreach($takhtis as $t)
                                                            <option value="{{ $t->takhti_number }}" 
                                                                {{ $activeTakhti == $t->takhti_number ? 'selected' : '' }}>
                                                                {{ $t->subject }} - {{ $t->takhti_number }}  
                                                            </option>
                                                        @endforeach
                                                        
                                                    </select>
                                                </div>

                                                <div>
                                                    <input type="number" name="page" placeholder="Enter Page No" style="width: 140px; height: 45px; padding: 0 15px; border: 1px solid #e1e1e1; margin: 0; box-sizing: border-box; text-align: center; border-radius: 0;">
                                                </div>

                                                <div>
                                                    <button class="thm-btn brd-rd40 m-0" type="submit" style="height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0 30px; border: none; box-sizing: border-box; cursor: pointer;">Search</button>
                                                </div>

                                                @if($next)
                                                    <div>
                                                        <a href="{{ route('page', [$resource->slug, 'page' => $next->number]) }}" class="thm-btn brd-rd40 m-0" style="height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0 25px; box-sizing: border-box; text-decoration: none;">Next</a>
                                                    </div>
                                                @endif

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="row mrg15 masonry">
                                @foreach($resource->children as $child)
                                <div class="{{ request()->page ? 'col-12' : 'col-md-2 col-sm-6 col-lg-2' }} fltr-itm fltr-itm1 mb-4 text-center">
                                    <labe>
                                        {{ $child->title }}
                                        <br>
                                    </labe>
                                    @if(request()->page)
                                        <br>
                                        <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}" width="100%">
                                    @else
                                        <a href="{{ route('page', [$resource->slug, 'page' => $child->number]) }}" title="">
                                        <br>
                                            <img src="{{ asset('/storage/'.$child->image) }}" alt="{{ $child->title }}" width="100%">
                                        </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="col-md-12 w-100">
                                @if($prev)
                                    <div>
                                        <a href="{{ route('page', [$resource->slug, 'page' => $prev->number]) }}" class="thm-btn brd-rd40 mt-2 mb-5 pull-left" type="submit">Previous</a>
                                    </div>
                                @endif
                                @if($next)
                                    <div>
                                        <a href="{{ route('page', [$resource->slug, 'page' => $next->number]) }}" class="thm-btn brd-rd40 mt-2 mb-5 pull-right" type="submit">Next</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('site.inc.footer')
    </main>
@stop