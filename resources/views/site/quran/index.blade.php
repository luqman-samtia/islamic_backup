@extends('site.layout.master')

@section('title', 'Tajweed Quran 15')

@section('custom_css')
    {{-- Select2 CSS (searchable dropdowns). Agar adblock block kare to bhi dropdown chalega, bas plain dikhega. --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" rel="stylesheet" />

    <style>
        .contact-form>form {
            max-width: none;
        }

        .contact-form>form input,
        .contact-form>form select,
        .contact-form>form textarea {
            border: 1px solid #ededed;
        }

        /* Styles for the toggle buttons */
        .quran-toggle-buttons {
            text-align: center;
            margin-bottom: 40px;
        }

        .quran-toggle-buttons .thm-btn {
            background-color: #f0f0f0;
            color: #333;
            border: 1px solid #ddd;
            margin: 0 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quran-toggle-buttons .thm-btn.active {
            background-color: #c79f1a;
            color: #fff;
            border-color: #c79f1a;
        }

        .quran-toggle-buttons .thm-btn:hover {
            transform: translateY(-2px);
        }

        .loading-spinner {
            text-align: center;
            padding: 40px 0;
            display: none;
        }

        .loading-spinner.show {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #c79f1a;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hide para select by default */
        #para-select-container {
            display: none;
        }

        /* --- Select2 theming to match existing form inputs --- */
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 48px !important;
            border: 1px solid #ededed;
            display: flex;
            align-items: center;
            padding: 0 8px;
            border-radius: 4px;
            margin-bottom:10px !important;
        }

       #searchForm .mrg20 {
                align-items: center !important;
            }

            .select2-container .select2-selection--single,
            #searchForm input[type="number"] {
                height: 48px !important;
                margin-top :0px !important;
            }

            #searchForm .thm-btn {
                margin-top: 0 !important;
                height: 48px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: normal;
            color: #333;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 46px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #c79f1a;
        }

        .select2-dropdown {
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
                        <h2>Tajweed Quran 15</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>Tajweed Quran 15</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="gap" style="padding-top: 20px;">
                <div class="container">
                    <div class="prtfl-wrap text-center">
                        <div class="serv-wrap text-center remove-ext3">
                            {{-- Search Form --}}
                            <div class="row contact-form-row" id="stickyFormContainer">
                                <div class="col-md-12">
                                    <div class="contact-form text-center mb-5">
                                        <form id="searchForm" action="{{ route('search') }}">
                                                <div class="row mrg20 justify-content-center align-items-start text-center">
                                                    <!-- Surah Select - Show by default -->
                                                <div id="surah-select-container" class="col-md-3 col-sm-6 col-lg-3">
                                                    <select name="surat" id="surah-select">
                                                        <option value="">-- Select Surah --</option>
                                                        @foreach ($quran as $surat)
                                                            <option value="{{ $surat->slug }}" data-first="{{ $surat->first_page }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Para Select - Hidden by default -->
                                                <div id="para-select-container" class="col-md-3 col-sm-6 col-lg-3">
                                                    <select name="para" id="para-select">
                                                        <option value="">-- Select Para --</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-3 col-sm-6 col-lg-3">
                                                    <input type="number" name="page" placeholder="Enter Page No">
                                                </div>
                                                <div class="col-md-2 col-sm-12 col-lg-2">
                                                    <button class="thm-btn brd-rd40 " type="submit">Search</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="quran-toggle-buttons">
                                <button id="show-surahs" class="thm-btn brd-rd40 active" type="button">Surah</button>
                                <button id="show-paras" class="thm-btn brd-rd40" type="button">Para</button>
                            </div>

                            <div class="loading-spinner" id="loadingSpinner">
                                <div class="spinner"></div>
                                <p>Loading Paras...</p>
                            </div>

                            {{-- Surah List --}}
                            <div id="surah-list">
                                <div class="row">
                                    @foreach ($quran as $surat)
                                        <div class="col-md-3 col-sm-6 col-lg-3">
                                            <div class="srv-box2">
                                                <i class="flaticon-quran-rehal"></i>
                                                <div class="srv-info2">
                                                    <h4>{{ $surat->title }}</h4>
                                                    <a href="{{ route('quranSurat', $surat->slug) }}" title="">Read More<i class="flaticon-right-arrow"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div id="para-list" style="display: none;">
                                <div class="row" id="para-list-content">
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

{{-- Self-loading script: jQuery + Select2 ko khud load karta hai, dono ready hone par hi app start hota hai.
     Isliye jQuery footer/head kahin bhi ho, ya adblock/slow network ho, "jQuery is not defined" error nahi aayega. --}}
<script !src="">
(function () {
    function loadScript(src, cb) {
        var s = document.createElement('script');
        s.src = src;
        s.onload = cb;
        s.onerror = function () { console.warn('Failed to load: ' + src); cb(); };
        document.head.appendChild(s);
    }

    function ensureJQuery(next) {
        if (window.jQuery) { next(); return; }
        // Project ki local jQuery pehle (adblock isko block nahi karta), warna CDN
        loadScript("{{ asset('assets/js/jquery.min.js') }}", function () {
            if (window.jQuery) { next(); }
            else { loadScript('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js', next); }
        });
    }

    // function ensureSelect2(next) {
    //     if (window.jQuery && jQuery.fn && jQuery.fn.select2) { next(); return; }
    //     loadScript('https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', next);
    // }
    function ensureSelect2(next) {
            if (window.jQuery && jQuery.fn && jQuery.fn.select2) { next(); return; }
            loadScript('https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/select2.min.js', function () {
                // Plugin attach hone ka intezaar karo (kabhi onload ke baad bhi 1 tick lagta hai)
                var tries = 0;
                (function waitForSelect2() {
                    if (window.jQuery && jQuery.fn && jQuery.fn.select2) {
                        next();
                    } else if (tries < 50) {
                        tries++;
                        setTimeout(waitForSelect2, 50);
                    } else {
                        console.warn('Select2 load hone mein der ho gayi.');
                        next();
                    }
                })();
            });
        }

    function startApp() {
        var $ = window.jQuery;
        var hasSelect2 = !!($ && $.fn && $.fn.select2);

        function run() {
            var contactFormRow = ($('.contact-form-row').offset().top - 92);
            $(window).on('scroll', function () {
                var scroll = $(window).scrollTop();
                if (scroll >= contactFormRow) {
                    $('.contact-form-row').addClass('sticky');
                } else {
                    $('.contact-form-row').removeClass('sticky');
                }
            });

            var surahButton = document.getElementById('show-surahs');
            var paraButton = document.getElementById('show-paras');
            var surahList = document.getElementById('surah-list');
            var paraList = document.getElementById('para-list');
            var paraListContent = document.getElementById('para-list-content');
            var loadingSpinner = document.getElementById('loadingSpinner');

            var surahSelectContainer = document.getElementById('surah-select-container');
            var paraSelectContainer = document.getElementById('para-select-container');
            var paraSelect = document.getElementById('para-select');

            // --- Select2 init (searchable dropdowns) ---
            if (hasSelect2) {
                $('#surah-select').select2({
                    placeholder: '-- Select Surah --',
                    allowClear: true,
                    width: '100%'
                });
                $('#para-select').select2({
                    placeholder: '-- Select Para --',
                    allowClear: true,
                    width: '100%'
                });
            } else {
                console.warn('Select2 not available - plain dropdowns will be used.');
            }

            if (surahButton && paraButton && surahList && paraList) {

                surahButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    paraList.style.display = 'none';
                    surahList.style.display = 'block';
                    loadingSpinner.classList.remove('show');
                    paraButton.classList.remove('active');
                    surahButton.classList.add('active');

                    surahSelectContainer.style.display = 'block';
                    paraSelectContainer.style.display = 'none';
                });

                paraButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    surahSelectContainer.style.display = 'none';
                    paraSelectContainer.style.display = 'block';

                    if (paraListContent.innerHTML.trim() === '') {
                        loadingSpinner.classList.add('show');

                        $.ajax({
                            url: "{{ route('quran.paraList') }}",
                            type: 'GET',
                            dataType: 'json',
                            success: function (data) {
                                loadingSpinner.classList.remove('show');
                                surahList.style.display = 'none';
                                paraList.style.display = 'block';
                                surahButton.classList.remove('active');
                                paraButton.classList.add('active');

                                paraSelect.innerHTML = '<option value="">-- Select Para --</option>';
                                data.forEach(function (para) {
                                    var option = document.createElement('option');
                                    option.value = para.para_no;
                                    option.textContent = para.para_name;
                                    option.setAttribute('data-first', para.first_page);
                                    paraSelect.appendChild(option);
                                });

                                // Select2 ko nayi options ka pata do (taake search mein aayein)
                                if (hasSelect2) {
                                    $('#para-select').trigger('change.select2');
                                }

                                renderParaList(data);
                            },
                            error: function (xhr) {
                                console.error('Error:', xhr);
                                loadingSpinner.classList.remove('show');
                                paraListContent.innerHTML = '<p class="col-12 text-center text-danger">Error loading Paras</p>';
                            }
                        });
                    } else {
                        surahList.style.display = 'none';
                        paraList.style.display = 'block';
                        surahButton.classList.remove('active');
                        paraButton.classList.add('active');
                    }
                });

                // Surah select change -> us surat ke pehle page par jao
                $('#surah-select').on('change', function () {
                    if (!this.value) { return; }
                    var opt = this.options[this.selectedIndex];
                    var first = opt.getAttribute('data-first');
                    if (first) {
                        window.location.href = "{{ route('quranSurat.page', ['__SLUG__', '__PAGE__']) }}"
                            .replace('__SLUG__', this.value)
                            .replace('__PAGE__', first);
                    } else {
                        window.location.href = "{{ route('quranSurat', '') }}/" + this.value;
                    }
                });

                // Para select change
                $('#para-select').on('change', function () {
                    if (!this.value) { return; }
                    var opt = this.options[this.selectedIndex];
                    var first = opt.getAttribute('data-first');
                    if (first) {
                        window.location.href = "{{ route('quranSurat.page', ['__SLUG__', '__PAGE__']) }}"
                            .replace('__SLUG__', 'para-' + this.value)
                            .replace('__PAGE__', first);
                    } else {
                        window.location.href = "{{ route('quran.para', '') }}/" + this.value;
                    }
                });
            }

            function renderParaList(paras) {
                var html = '';
                paras.forEach(function (para) {
                    html += '' +
                        '<div class="col-md-3 col-sm-6 col-lg-3">' +
                            '<div class="srv-box2">' +
                                '<i class="flaticon-quran-rehal"></i>' +
                                '<div class="srv-info2">' +
                                    '<h4>' + para.para_name + '</h4>' +
                                    '<a href="{{ route('quran.para', '') }}/' + para.para_no + '" title="">Read More<i class="flaticon-right-arrow"></i></a>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
                });
                document.getElementById('para-list-content').innerHTML = html;
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', run);
        } else {
            run();
        }
    }

    // Chain: jQuery -> Select2 -> App
    ensureJQuery(function () {
        ensureSelect2(function () {
            startApp();
        });
    });
})();
</script>