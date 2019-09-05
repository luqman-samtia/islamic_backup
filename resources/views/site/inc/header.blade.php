<header class="style1">
    <div class="container">
        <div class="logo">
            <a href="{{ route('site') }}" title="{{ config('app.name') }}"><img src="{{ asset('assets/images/logo1.png') }}" alt=""></a>
        </div>
        <nav>
            <div>
                <a class="thm-btn brd-rd40" href="{{ route('contactUs') }}" title="">Contact Us</a>
                <ul>
                    <li><a href="{{ route('site') }}" title="">Home</a></li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">Islamic Resources</a>
                        <ul>
                            @foreach($resources as $resource)
                            <li><a href="{{ route('page', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="menu-item-has-children">
                        <a href="#" title="">Articles</a>
                        <ul>
                            @foreach($articles as $resource)
                                <li><a href="{{ route('artical', $resource->slug) }}" title="{{ $resource->title }}">{{ $resource->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('quranPage') }}" title="">Read Quran</a></li>
                    <li><a href="{{ route('charges') }}" title="">Charges</a></li>
                    {{--<li><a href="crowd-funding.html" title="">Donate</a></li>
                    <li class="menu-item-has-children"><a href="#" title="">Pages</a>
                        <ul>
                            <li><a href="team.html" title="">Team Grid View</a></li>
                            <li><a href="team2.html" title="">Team Round View</a></li>
                            <li><a href="portfolio.html" title="">Our Portfolio</a></li>
                            <li><a href="services.html" title="">Our Services</a></li>
                        </ul>
                    </li>--}}
{{--                    <li><a href="{{ route('faq') }}" title="">FAQ</a></li>--}}
{{--                    <li><a href="{{ route('contactUs') }}" title="">Contact</a></li>--}}
                </ul>
            </div>
        </nav>
    </div>
</header>

