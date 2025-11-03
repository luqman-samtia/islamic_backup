@extends('site.layout.master')

@section('title', 'Quran')

@section('custom_css')
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
                        <h2>Quran</h2>
                        <ul class="breadcrumbs">
                            <li><a href="{{ route('site') }}" title="">Home</a></li>
                            <li>Quran</li>
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
                                            <div class="row mrg20 justify-content-center align-items-center text-center">
                                                <div class="col-md-3 col-sm-6 col-lg-3">
                                                    <select name="surat">
                                                        <option value="">-- Select Surah --</option>
                                                        @foreach ($quran as $surat)
                                                            <option value="{{ $surat->slug }}">{{ $surat->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3 col-sm-6 col-lg-3">
                                                    <input type="number" name="page" placeholder="Page">
                                                </div>
                                                <div class="col-md-2 col-sm-12 col-lg-2">
                                                    <button class="thm-btn brd-rd40 mt-3" type="submit">Search</button>
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

{{-- @section('custom_js') --}}
    <script !src="">
        // $(document).ready(function() {
        document.addEventListener('DOMContentLoaded', function() {
            var contactFormRow = ($('.contact-form-row').offset().top - 92);
            $(window).on('scroll', function() {
                var scroll = $(window).scrollTop();
                if (scroll >= contactFormRow) {
                    $('.contact-form-row').addClass('sticky');
                } else {
                    $('.contact-form-row').removeClass('sticky');
                }
            });

            const surahButton = document.getElementById('show-surahs');
            const paraButton = document.getElementById('show-paras');
            const surahList = document.getElementById('surah-list');
            const paraList = document.getElementById('para-list');
            const paraListContent = document.getElementById('para-list-content');
            const loadingSpinner = document.getElementById('loadingSpinner');

            if (surahButton && paraButton && surahList && paraList) {

                surahButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    paraList.style.display = 'none';
                    surahList.style.display = 'block';
                    loadingSpinner.classList.remove('show');
                    paraButton.classList.remove('active');
                    surahButton.classList.add('active');
                });

                paraButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    if (paraListContent.innerHTML.trim() === '') {
                        loadingSpinner.classList.add('show');
                        
                        $.ajax({
                            url: "{{ route('quran.paraList') }}",
                            type: 'GET',
                            dataType: 'html',
                            success: function(html) {
                                paraListContent.innerHTML = html;
                                loadingSpinner.classList.remove('show');
                                surahList.style.display = 'none';
                                paraList.style.display = 'block';
                                surahButton.classList.remove('active');
                                paraButton.classList.add('active');
                            },
                            error: function(xhr) {
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
            }
        });
    </script>
{{-- @stop --}}