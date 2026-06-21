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
                                       <form action="" style="max-width: 100% !important;" id="searchForm">
                                            {{-- <div class="d-flex flex-wrap align-items-center mb-4" id="stickyFormContainer" style="justify-content: space-evenly;">                                                
                                                @if($prev)
                                                    <div>
                                                        <a href="{{ route('page', [$resource->slug, 'page' => $prev->number]) }}" class="thm-btn brd-rd40 m-0" style="height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0 25px; box-sizing: border-box; text-decoration: none;">Previous</a>
                                                    </div>
                                                @endif

                                                <div>
                                                    <select name="takhti" class="form-control w-100" 
                                                        style="width: 180px; height: 45px; padding: 0 15px; border: 1px solid #e1e1e1; 
                                                            margin: 0; box-sizing: border-box; text-align: center; border-radius: 0;">
                                                        
                                                        <option value="">-- Select --</option>
                                                        
                                                        @foreach($takhtis as $t)
                                                            <option value="{{ $t->takhti_number }}"
                                                                    data-subject="{{ \Illuminate\Support\Str::slug($t->subject) }}"
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
                                                    <button class="thm-btn brd-rd40 m-0" id="pageSearchBtn" type="submit" style="height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0 30px; border: none; box-sizing: border-box; cursor: pointer;">Search</button>
                                                </div>

                                                @if($next)
                                                    <div>
                                                        <a href="{{ route('page', [$resource->slug, 'page' => $next->number]) }}" class="thm-btn brd-rd40 m-0" style="height: 45px; display: inline-flex; align-items: center; justify-content: center; padding: 0 25px; box-sizing: border-box; text-decoration: none;">Next</a>
                                                    </div>
                                                @endif

                                            </div> --}}
                                            <div class="search-bar-wrap" id="stickyFormContainer">
                                                @if($prev)
                                                    <a href="{{ route('page', [$resource->slug, 'page' => $prev->number]) }}" class="thm-btn brd-rd40 search-bar-item">Previous</a>
                                                @endif

                                                <select name="takhti" class="form-control search-bar-item search-select">
                                                    <option value="">-- Select --</option>
                                                    @foreach($takhtis as $t)
                                                        <option value="{{ $t->takhti_number }}"
                                                                data-subject="{{ \Illuminate\Support\Str::slug($t->subject) }}"
                                                                {{ $activeTakhti == $t->takhti_number ? 'selected' : '' }}>
                                                            {{ $t->subject }} - {{ $t->takhti_number }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <input type="number" name="page" placeholder="Enter Page No" class="search-bar-item search-input">

                                                <button class="thm-btn brd-rd40 search-bar-item" id="pageSearchBtn" type="submit">Search</button>

                                                @if($next)
                                                    <a href="{{ route('page', [$resource->slug, 'page' => $next->number]) }}" class="thm-btn brd-rd40 search-bar-item">Next</a>
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
<style>
.search-bar-wrap {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 30px;
}

.search-bar-wrap .search-bar-item {
    height: 45px;
    box-sizing: border-box;
    margin: 0;
    float: none !important;
    width: auto;
}

.search-bar-wrap a.thm-btn,
.search-bar-wrap button.thm-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0 28px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.search-bar-wrap .search-select,
.search-bar-wrap .search-input {
    padding: 0 15px;
    border: 1px solid #e1e1e1;
    text-align: center;
    border-radius: 0;
    margin-top: 0 !important;
}

.search-bar-wrap .search-select { width: 220px !important; }
.search-bar-wrap .search-input  { width: 170px !important; }

/* Mobile */
@media (max-width: 575px) {
    .search-bar-wrap {
        flex-direction: column;
        gap: 12px;
    }
    .search-bar-wrap .search-bar-item {
        width: 100% !important;
        max-width: 320px;
    }
}
</style>
@stop
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    var form      = document.getElementById('searchForm');
    var takhti    = form.querySelector('select[name="takhti"]');
    var searchBtn = document.getElementById('pageSearchBtn');
    var base      = window.location.pathname;

    // takhti.addEventListener('change', function () {
    //     var num = this.value;
    //     if (!num) { window.location.href = base; return; }
    //     window.location.href = base + '?takhti=' + encodeURIComponent(num);
    // });
    
    takhti.addEventListener('change', function () {
        var num = this.value;
        if (!num) { return; }   
        window.location.href = base + '?takhti=' + encodeURIComponent(num);
    });

    // searchBtn.addEventListener('click', function () {
    //     takhti.disabled = true;
    // });
     searchBtn.addEventListener('click', function (e) {
        var takhtiVal = takhti.value;
        var pageVal   = pageInput.value.trim();

        if (!takhtiVal && !pageVal) {
            e.preventDefault();
            return;
        }

        if (pageVal) {
            takhti.value = '';
        }
    });
});
</script> --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form      = document.getElementById('searchForm');
    var takhti    = form.querySelector('select[name="takhti"]');
    var pageInput = form.querySelector('input[name="page"]');
    var searchBtn = document.getElementById('pageSearchBtn');
    var base      = window.location.pathname;

    var params = new URLSearchParams(window.location.search);

    if (!params.has('takhti')) {
        takhti.value = '';
    }

    takhti.addEventListener('change', function () {
        var num = this.value;
        if (!num) { return; }
        window.location.href = base + '?takhti=' + encodeURIComponent(num);
    });

    searchBtn.addEventListener('click', function (e) {
        e.preventDefault(); 

        var pageVal = pageInput.value.trim();

        if (!pageVal) {
            return;
        }

        window.location.href = base + '?page=' + encodeURIComponent(pageVal);
    });
});
</script>