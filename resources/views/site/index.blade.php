@extends('site.layout.master')

@section('content')
    <main>
        @include('site.inc.loader')

        @include('site.inc.header')

        @include('site.inc.header_responsive')


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
                                <a class="thm-btn brd-rd40" href="#" title="">Read More</a>
                            </div>
                        </div>
                        <div class="featured-item" style="background-image: url('{{ asset('assets/images/resources/slide1.jpg') }}');">
                            <div class="featured-cap">
                                <img src="{{ asset('assets/images/resources/bsml-txt.png') }}" alt="bsml-txt.png">
                                <h1><img src="{{ asset('assets/images/resources/ayat-txt3-1.png') }}" alt="ayat-txt-color.png"></h1>
                                <h3>Or increase a little more to it. And recite the Qur’an with most pleasant pauses</h3>
                                <span>"Surah Al-Muzzammil Vesre 4"</span>
                                <a class="thm-btn brd-rd40" href="#" title="">Read More</a>
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
                                        We have 4 years experience. Now we are offering Tajweed-e-Qiraat course and Dars-e-Nizami course.
                                        As concerned for male students we have male teachers and for female students we have female teachers.</p>
                                    <a class="secndry-btn brd-rd40" href="#" title="">Learn More</a>
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
                <div class="fixed-bg ptrn-bg" style="background-image: url(assets/images/pattern-bg.jpg);"></div>
                <div class="container">
                    <div class="sec-title text-center">
                        <div class="sec-title-inner">
                            <span>Our Expert</span>
                            <h3>Islamic Scholars</h3>
                        </div>
                    </div>
                    <div class="team-wrap2 text-center remove-ext3">
                        <div class="row justify-content-center">
{{--                            <div class="col-md-1 col-lg-1 hidden-sm hidden-xs"></div>--}}
                            <div class="col-md-4 col-sm-6 col-lg-4 fadeIn" data-wow-duration=".8s" data-wow-delay=".2s">
                                <div class="team-box2">
                                    <img src="assets/images/resources/Qari1.jpeg" style="width: 120px;height: 120px;object-fit: cover;" alt="team-img2-1.jpg">
                                    <div class="team-info2">
                                        <h4>Qari M. Habib Ur Rehman</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-lg-4 fadeIn" data-wow-duration=".8s" data-wow-delay=".3s">
                                <div class="team-box2">
                                    <img src="assets/images/resources/Qari2.jpeg" style="width: 120px;height: 120px;object-fit: cover;" alt="team-img2-1.jpg">
                                    <div class="team-info2">
                                        <h4>Qari M. Muratib</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-lg-4 fadeIn" data-wow-duration=".8s" data-wow-delay=".4s">
                                <div class="team-box2">
                                    <img src="assets/images/resources/Qari3.jpeg" style="width: 120px;height: 120px;object-fit: cover;" alt="team-img2-1.jpg">
                                    <div class="team-info2">
                                        <h4>Qari M. Khalil Ur Rehman</h4>
                                    </div>
                                </div>
                            </div>
{{--                            <div class="col-md-1 col-lg-1 hidden-sm hidden-xs"></div>--}}

                            <div class="col-md-4 col-sm-6 col-lg-4 fadeIn" data-wow-duration=".8s" data-wow-delay=".3s">
                                <div class="team-box2">
                                    <img src="assets/images/resources/Qari4.jpeg" style="width: 120px;height: 120px;object-fit: cover;" alt="team-img2-1.jpg">
                                    <div class="team-info2">
                                        <h4>Qari M. Nasir</h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 col-lg-4 fadeIn" data-wow-duration=".8s" data-wow-delay=".3s">
                                <div class="team-box2">
                                    <img src="assets/images/resources/Qari5.jpeg" style="width: 120px;height: 120px;object-fit: cover;" alt="team-img2-1.jpg">
                                    <div class="team-info2">
                                        <h4>Qari M. Ramzan</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="gap gray-layer opc95">
                <div class="fixed-bg" style="background-image: url(assets/images/parallax4.jpg);"></div>
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
                            <div class="testi-itm">
                                <i><img src="{{ asset('assets/images/resources/parent1.jpeg') }}" style="width: 110px;height: 110px;object-fit: cover;" alt="testi-img1.jpg"></i>
                                <div class="testi-info">
                                    <h4>Muhammad Bilal</h4>
                                    <p><i>"</i>Qari Habib is an unmatched Quraan tutor in the city equipped with fatherly love for his students
                                        and armed with professional knowledge accompanied by skill to deliver where by his students develop natural
                                        fluency to read the Holy Scripture. He has been giving private lessons to my two children since 18 months.
                                        I recommend him as a most effective and time efficient tutor.<i>"</i></p>
                                </div>
                            </div>
                            <div class="testi-itm">
                                <i><img src="{{ asset('assets/images/resources/parent2.jpeg') }}" style="width: 110px;height: 110px;object-fit: cover;" alt="testi-img1.jpg"></i>
                                <div class="testi-info">
                                    <h4>Awais Ahmed</h4>
                                    <p><i>"</i>Hafiz Qari Habib is a very good teacher of Qiraat. If you want to learn Quran with the complete rules
                                        and principles of Qiraat then there is no other option except of Hafiz Qari Habib. I suggest you because he
                                        has a very simple pickable and basic method of teaching Qiraat, with the complete principles and laws of
                                        reading Quran. If you are interested in learning Quran then please contact him as soon as early.<i>"</i></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
{{--        <section>--}}
{{--            <div class="gap thm-layer opc9">--}}
{{--                <div class="fixed-bg" style="background-image: url('{{asset('assets/images/parallax7.jpg')}}');"></div>--}}
{{--                <div class="container">--}}
{{--                    <div class="nwsltr-wrp text-center">--}}
{{--                        <div class="nwsltr-innr">--}}
{{--                            <div class="nwsltr-title">--}}
{{--                                <h3>Newsletter</h3>--}}
{{--                                <span>Subscribe to our mailing list</span>--}}
{{--                            </div>--}}
{{--                            <form>--}}
{{--                                <input type="email" placeholder="Enter your email">--}}
{{--                                <button type="submit">Sign up</button>--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </section>--}}

        @include('site.inc.footer')
    </main>
@stop