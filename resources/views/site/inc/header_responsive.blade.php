<div class="rspn-hdr">
    <div class="rspn-mdbr">
        <ul class="rspn-scil">
            <li><a href="#" title="Twitter" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="#" title="Facebook" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="#" title="Linkedin" target="_blank"><i class="fa fa-linkedin"></i></a></li>
            <li><a href="#" title="Google Plus" target="_blank"><i class="fa fa-google-plus"></i></a></li>
        </ul>
        <form class="rspn-srch">
            <input type="text" placeholder="Enter Your Keyword" />
            <button type="submit"><i class="fa fa-search"></i></button>
        </form>
    </div>
    <div class="lg-mn">
        <div class="logo">
            <a href="{{ route('site') }}" title="{{ config('app.name') }}">
                <img src="{{ asset('assets/images/logo2.png') }}">
            </a>
        </div>
        <div class="rspn-cnt">
            <span>
                <i class="fa fa-envelope thm-clr"></i>
                <a href="mailto:info@equraninstitute.com" title="">
                    <span class="__cf_email__" data-cfemail="3851565e57785a514b555154545950165b5755">info@equraninstitute.com</span>
                </a>
            </span>
            <span><i class="fa fa-phone thm-clr"></i>+92-311-5165709</span>
        </div>
        <span class="rspn-mnu-btn"><i class="fa fa-list-ul"></i></span>
    </div>
    <div class="rsnp-mnu">
        <span class="rspn-mnu-cls"><i class="fa fa-times"></i></span>
        <ul>
            <li><a href="{{ route('site') }}" title="">Home</a></li>
            <li class="menu-item-has-children">
                <a href="#" title="">Islamic Resources</a>
                <ul>
                    @foreach(\App\Resources::parent(null)->get() as $resource)
                        <li><a href="{{ route('page', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                    @endforeach
                </ul>
            </li>
            <li><a href="{{ route('quranPage') }}" title="">Read Quran</a></li>

            {{--<li><a href="event.html" title="">Event</a></li>
            <li><a href="crowd-funding.html" title="">Donate</a></li>
            <li class="menu-item-has-children"><a href="#" title="">Pages</a>
                <ul>
                    <li><a href="team.html" title="">Team Grid View</a></li>
                    <li><a href="team2.html" title="">Team Round View</a></li>
                    <li><a href="portfolio.html" title="">Our Portfolio</a></li>
                    <li><a href="services.html" title="">Our Services</a></li>
                </ul>
            </li>
            <li><a href="about.html" title="">About</a></li>--}}
{{--            <li><a href="{{ route('faq') }}" title="">FAQ</a></li>--}}
            <li><a href="{{ route('contactUs') }}" title="">Contact</a></li>
        </ul>
    </div>
</div>