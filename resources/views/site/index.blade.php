@extends('site.layout.master')

@section('content')
    <main>
        @include('site.inc.loader')

        @include('site.inc.header')

        @include('site.inc.header_responsive')
  <!-- SweetAlert2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <section>
            <div class="gap no-gap owl-yellow">
                <div class="featured-area-wrap text-center">
                    <div class="featured-area owl-carousel">
                        <div class="featured-item" style="background-image: url('{{ asset('assets/images/resources/slide1.jpg') }}');">
                            <div class="featured-cap">
                                <img src="{{ asset('assets/images/resources/bsml-txt.png') }}" alt="bsml-txt.png">
                                <h1><img src="{{ asset('assets/images/resources/ayat-txt3.png') }}" alt="ayat-txt-color.png"></h1>
                                <h3>Or increase a little more to it. And recite the Qur’an with most pleasant pauses</h3>
                                <span>"Surah Al-Muzzammil Vesre 4"</span>
{{--                                <a class="thm-btn brd-rd40" href="#" title="">Read More</a>--}}
                            </div>
                        </div>
                        <div class="featured-item" style="background-image: url('{{ asset('assets/images/resources/slide1.jpg') }}');">
                            <div class="featured-cap">
                                <img src="{{ asset('assets/images/resources/bsml-txt.png') }}" alt="bsml-txt.png">
                                <h1><img src="{{ asset('assets/images/resources/ayat121.png') }}" alt="ayat-txt-color.png"></h1>
                                <h3>Those to whom We have given the Book recite it with its true recital</h3>
                                <span>"Surah Al-Baqarah Verse 121"</span>
                            </div>
                        </div>
                        <div class="featured-item" style="background-image: url('{{ asset('assets/images/resources/slide1.jpg') }}');">
                            <div class="featured-cap">
                                <img src="{{ asset('assets/images/resources/bsml-txt.png') }}" alt="bsml-txt.png">
                                <h1><img src="{{ asset('assets/images/resources/hadees 3.png') }}" alt="ayat-txt-color.png"></h1>
                                <h3>Seeking knowledge is a duty upon every Muslim</h3>
                                <span>"Sunan Ibn Majah : Vol. 1 : Book 1 : 224"</span>
                            </div>
                        </div>
                        <div class="featured-item" style="background-image: url('{{ asset('assets/images/resources/slide1.jpg') }}');">
                            <div class="featured-cap">
                                <img src="{{ asset('assets/images/resources/bsml-txt.png') }}" alt="bsml-txt.png">
                                <h1><img src="{{ asset('assets/images/resources/hadees 4.png') }}" alt="ayat-txt-color.png"></h1>
                                <h3>The best amongst you are the ones who learn Qur'an and teach it to others</h3>
                                <span>"Sahih Bukhari : 5027"</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="lft-shp shp-lyr"></div>
                <div class="container">
                    <div class="plrs-wrap text-center remove-ext5">
                        <div class="row">
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <div class="plr-box">
                                    <i class="flaticon-islamic-pray"></i>
                                    <div class="pilr-info">
                                        <h4>Salah</h4>
                                        <p>“O you who have believed, seek help through patience and prayer. Indeed, Allah is with the patient.”</p>
                                        <p>(Q 2:153)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <div class="plr-box">
                                    <i class="flaticon-islamic-ramadan"></i>
                                    <div class="pilr-info">
                                        <h4>Fasting</h4>
                                        <p>"Fasting is prescribed for you as it was prescribed for those before you, that you may attain taqwaa."</p>
                                        <p>(Q 2:183)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <div class="plr-box">
                                    <i class="flaticon-charity"></i>
                                    <div class="pilr-info">
                                        <h4>Zakah</h4>
                                        <p>“And keep the prayer established, and pay the zakah, and bow your heads with those who bow down.”</p>
                                        <p>(Q 2:43)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6 col-lg-3">
                                <div class="plr-box">
                                    <i class="flaticon-kaaba-building"></i>
                                    <div class="pilr-info">
                                        <h4>Hajj</h4>
                                        <p>"Then let them end their untidiness and fulfill their vows and perform Tawaf around the ancient House."</p>
                                        <p>(Q 22:29)</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap white-grad-layer">
                <div class="fixed-bg" style="background-image: url('{{ asset('assets/images/parallax1.jpg') }}');"></div>
                <div class="container">
                    <div class="abot-wrap">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 col-lg-6">
                                <div class="abot-sec">
                                    <div class="sec-title">
                                        <div class="sec-title-inner">
                                            <h3><span class="secndry-clr">About</span> Us</h3>
                                        </div>
                                    </div>
                                    <p>Online Quran learning started while considering the problem of the parents in finding qualified Quran teachers near to their home.
                                        The online way of learning holy Quran has a lot of advantages as compared to the conventional Quran classes.
                                        We have 12 years experience. Now we are offering Tajweed-e-Qiraat course and Dars-e-Nizami course.
                                        As concerned for male students we have male teachers and for female students we have female teachers.</p>
{{--                                    <a class="secndry-btn brd-rd40" href="#" title="">Learn More</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap">
                <div class="fixed-bg" style="background-image: url('{{ asset('assets/images/parallax2.jpg') }}');"></div>
                <div class="container">
                    <div class="sec-title text-center">
                        <div class="sec-title-inner">
                            <h3><span class="secndry-clr">Our</span> Services</h3>
                        </div>
                    </div>
                    <div class="serv-wrap">
                        <div class="row">
                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="srv-tl">
                                    <h2>We Have a <span>Mission</span></h2>
                                    <p>As compared to other online quran Institute, Our Quran academy provides effective
                                        classes and Tajweed( Reading of the Holy Quran with correct pronunciation and accent )
                                        classes at affordable charges to let most of the muslims learn quran at home online.</p>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-12 col-lg-8">
                                <div class="remove-ext9">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="serv-box">
                                                <i class="flaticon-quran-rehal"></i>
                                                <div class="serv-info">
                                                    <h4>Quran Teaching</h4>
                                                    <p>As Quran is the prime source of guidance for all the humanity, especially Muslims, therefore, it is the duty of parents to ensure that the kids get proper Quran education.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="serv-box">
                                                <i class="flaticon-islamic-pray"></i>
                                                <div class="serv-info">
                                                    <h4>Kalmay</h4>
                                                    <p>The six Kalimah in Islam are six significant parts of one's religious belief, mostly taken from hadiths (in some traditions, six phrases, then known as the six kalimas.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="serv-box">
                                                <i class="flaticon-mosque"></i>
                                                <div class="serv-info">
                                                    <h4>Namaz</h4>
                                                    <p>The second rukan of Islam is “Namaz”. Namaz is the act done by Muslims by bowing their heads in the court of Allah. Allah obligated Namaz five times a day. </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="serv-box">
                                                <i class="flaticon-quran-rehal"></i>
                                                <div class="serv-info">
                                                    <h4>Tajweed-e-Qira'at Course</h4>
                                                    <p>Tajweed means to make beauty in reading.
                                                        It means to pronounce every letter correctly with all its qualities.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="serv-box">
                                                <i class="flaticon-quran-rehal"></i>
                                                <div class="serv-info">
                                                    <h4>Dars-e-Nizami Course</h4>
                                                    <p>Dars-e-Nizami is a study curriculum or system used in traditional Islamic institutions (madrassas) and Dar Ul Ulooms.</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-lg-6">
                                            <div class="serv-box">
                                                <i class="flaticon-islamic-pray"></i>
                                                <div class="serv-info">
                                                    <h4>Qaida</h4>
                                                    <p>A series of books for beginners to learn Quranic Arabic. It is used to teach children how to read the Quran.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap white-layer opc9">
                <div class="fixed-bg ptrn-bg" style="background-image: url('{{ asset('assets/images/pattern-bg.jpg') }}');"></div>
                <div class="container">
                    <div class="sec-title text-center">
                        <div class="sec-title-inner">
                            <span>Our Expert</span>
                            <h3>Islamic Scholars</h3>
                        </div>
                    </div>
                    <div class="team-wrap2 text-center remove-ext3">
                        <div class="row justify-content-center">
                            @foreach($scholars as $scholar)
                                <div class="col-md-4 col-sm-6 col-lg-4 fadeIn" data-wow-duration=".8s" data-wow-delay=".2s">
                                    <div class="team-box2">
                                        <img src="{{ asset('/storage/'.$scholar->image) }}" style="width: 120px;height: 120px;object-fit: cover;" alt="team-img2-1.jpg">
                                        <div class="team-info2">
                                            <h4>{{$scholar->name}}</h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap gray-layer opc95">
                <div class="fixed-bg" style="background-image: url('{{ asset('assets/images/parallax4.jpg') }}');"></div>
                <div class="container">
                    <div class="evnt-pry-wrap">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-lg-12">
                                <div class="sec-title">
                                    <div class="sec-title-inner">
                                        <h3><span>Recent</span> Articles</h3>
                                    </div>
                                </div>
                                <div class="evnt-wrap remove-ext5">
                                    <div class="row mrg20">
                                        @foreach($posts as $post)
                                            <div class="col-md-4 col-sm-6 col-lg-4">
                                                <div class="evnt-box">
                                                    <div class="evnt-info">
                                                        <h4><a href="{{ route('artical', $post->slug) }}" title="">{{ $post->title }}</a></h4>
                                                        <ul class="pst-mta">
                                                            <li class="thm-clr">{{ $post->created_at->format('d/m/Y') }}</li>
                                                            <li>{{ $post->created_at->format('h:i A') }}</li>
                                                        </ul>
                                                        <p>{!! str_limit(strip_tags($post->content),150) !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap white-layer opc9">
                <div class="fixed-bg ptrn-bg" style="background-image: url('{{ asset('assets/images/pattern-bg.jpg') }}');"></div>
                <div class="container">
                    <div class="sec-title text-center">
                        <div class="sec-title-inner">
                            <span>What Our</span>
                            <h3>Student's Parent Say</h3>
                        </div>
                    </div>
                    <div class="testi-wrap text-center">
                        <div class="testi-car owl-carousel">
                            @foreach($testimonials as $testimonial)
                            <div class="testi-itm">
                                <i><img src="{{ asset('/storage/'.$testimonial->image) }}" style="width: 110px;height: 110px;object-fit: cover;" alt="testi-img1.jpg"></i>
                                <div class="testi-info">
                                    <h4>{{ $testimonial->name }}</h4>
                                    <p><i>"</i>{{ $testimonial->description }}<i>"</i></p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('site.inc.footer')
    </main>
   

@stop